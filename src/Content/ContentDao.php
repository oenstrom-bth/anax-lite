<?php

namespace Oenstrom\Content;

/**
 * Class for accessing the content table.
 */
class ContentDao
{
    /**
     * @var Database         $db the database object.
     */
    protected $db;


    /**
     * Constructor creating a Content data access object.
     *
     * @param object $db Database object.
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->db->connect();
    }


    /**
     * Get content based on type.
     *
     * @param string $type the type of content.
     * @param string $str the slug or path.
     * @return array with resultset.
     */
    public function getContent($type, $str)
    {
        switch ($type) {
            case "post":
                $type = "type = 'post' AND slug";
                break;
            case "page":
                $type = "type = 'page' AND path";
                break;
            case "block":
                $type = "type = 'block' AND slug";
                break;
        }
        $this->db->execute(
            "SELECT * FROM anax_content WHERE
            $type = ? AND published <= NOW() AND (deleted IS NULL OR deleted > NOW());",
            [$str]
        );
        return $this->db->fetchOne();
    }


    /**
     * Get one type of content.
     *
     * @param string $type which type to get.
     * @param integer $id the content id.
     * @return array with resultset.
     */
    public function getOne($type, $id)
    {
        $this->db->execute("SELECT * FROM anax_content WHERE id = ?", [$id]);
        //$this->content = $this->db->fetchObject("\Oenstrom\Content\Content");
        return $this->db->fetchObject($type);
    }


    /**
     * Get all content of a type and status.
     *
     * @param string $type which type to get.
     * @param string $status the status of the content.
     * @param string $class the class to use.
     * @return array with resultset.
     */
    public function getAll($type = "all", $status = "published", $class = "\Oenstrom\Content\Content")
    {
        switch ($status) {
            case 'nonpublished':
                $status = "(published > NOW() OR published IS NULL) AND (deleted IS NULL OR deleted > NOW())";
                break;

            case 'deleted':
                $status = "deleted <= NOW()";
                break;

            case 'published':
            default:
                $status = "published <= NOW() AND (deleted IS NULL OR deleted > NOW())";
                break;
        }
        switch ($type) {
            case "post":
                $type = "AND type = 'post'";
                break;

            case "page":
                $type = "AND type = 'page'";
                break;

            case "all":
            default:
                $type = "";
                break;
        }

        $this->db->execute("SELECT * FROM anax_content WHERE $status $type;");
        return $this->db->fetchAllClass($class);
    }


    /**
     * Create new content.
     *
     * @param string $title the content title.
     * @return integer the last insert id.
     */
    public function create($title)
    {
        $this->db->execute("INSERT INTO anax_content (title) VALUES (?)", [$title]);
        flash("success", "'$title' har skapats.");
        return $this->db->lastInsertId();
    }


    /**
     * Update content.
     *
     * @param array $fields the values to update with.
     * @param Content $contentObj the content object to update.
     * @return bool success or not.
     */
    public function update($fields, $contentObj)
    {
        // $this->content->update($fields);
        $contentObj->update($fields);

        if (!in_array($contentObj->get("type"), ["page", "post", "block"])) {
            flash("error", "Ogiltig innehållstyp.");
            return false;
        }
        if ($this->isTaken("path", $contentObj->get("path"), $contentObj->get("id"))) {
            flash("error", "Den angivna path:en är upptagen.");
            return false;
        }
        if ($this->isTaken("slug", $contentObj->get("slug"), $contentObj->get("id"))) {
            flash("error", "Den angivna slug:en är upptagen.");
            return false;
        }
        if (!empty($fields["published"]) && !$contentObj->get("published")) {
            flash("error", "Det angivna publiceringsdatumet är ogiltigt.");
            return false;
        }

        flash("success", "Innehållet har uppdaterats.");
        return $this->db->execute(
            "UPDATE anax_content SET
                title = ?, path = ?, slug = ?, data = ?, type = ?, filter = ?, published = ?, updated = CURRENT_TIMESTAMP
            WHERE id = ?;",
            [
                $contentObj->get("title"),
                $contentObj->get("path"),
                $contentObj->get("slug"),
                $contentObj->get("data"),
                $contentObj->get("type"),
                $contentObj->get("filter"),
                $contentObj->get("published"),
                $contentObj->get("id")
            ]
        );
    }


    /**
     * Toggle deletion of content.
     *
     * @param integer $id the content id.
     */
    public function toggleDeleted($id)
    {
        //$contentObj = $this->getOne($id);
        if ($this->getOne("\Oenstrom\Content\Content", $id)->get("deleted")) {
            flash("success", "Innehållet har lagts tillbaka.");
            $this->db->execute("UPDATE anax_content SET deleted = NULL WHERE id = ?;", [$id]);
        } else {
            flash("success", "Innehållet har tagits bort.");
            $this->db->execute("UPDATE anax_content SET deleted = CURRENT_TIMESTAMP WHERE id = ?;", [$id]);
        }
    }


    /**
     * Check if the path or slug is taken.
     *
     * @param string $type the type to check.
     * @param string $value the path or slug.
     * @param int $id the id of the content.
     * @return bool as taken or not.
     */
    private function isTaken($type, $value, $id)
    {
        $this->db->execute("SELECT EXISTS(SELECT 1 FROM anax_content WHERE $type = ? AND id != ? LIMIT 1) AS value;", [$value, $id]);
        return $this->db->fetchOne()->value;
    }
}
