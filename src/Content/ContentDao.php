<?php

namespace Oenstrom\Content;

class ContentDao
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->db->connect();
    }


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


    public function getOne($type, $id)
    {
        $this->db->execute("SELECT * FROM anax_content WHERE id = ?", [$id]);
        //$this->content = $this->db->fetchObject("\Oenstrom\Content\Content");
        return $this->db->fetchObject($type);
    }


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


    public function create($title)
    {
        $this->db->execute("INSERT INTO anax_content (title) VALUES (?)", [$title]);
        flash("success", "'$title' har skapats.");
        return $this->db->lastInsertId();
    }


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
     * Check if the path is taken or not.
     *
     * @param string $path the path to check.
     * @param int $id the id of the content.
     * @return bool as taken or not.
     */
    private function isTaken($type, $value, $id)
    {
        $this->db->execute("SELECT EXISTS(SELECT 1 FROM anax_content WHERE $type = ? AND id != ? LIMIT 1) AS value;", [$value, $id]);
        return $this->db->fetchOne()->value;
    }
}
