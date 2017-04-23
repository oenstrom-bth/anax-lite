<?php

namespace Oenstrom\Content;

class Content
{
    protected $id;
    protected $path;
    protected $slug;
    protected $title;
    protected $data;
    protected $type;
    protected $filter;
    protected $published;
    protected $created;
    protected $updated;
    protected $deleted;


    /**
     * Get the value of a specified property.
     *
     * @param string $var The name of the property.
     * @return mixed as the value of the property.
     */
    public function get($var)
    {
        return $this->{$var};
    }


    /**
     * Update the object.
     *
     * @param array $fields The new values.
     */
    public function update($fields)
    {
        $this->title = $fields["title"];
        $this->data = $fields["data"];
        $this->type = $fields["type"];
        $this->filter = $fields["filter"];
        $this->published = $this->validateDatetime($fields["published"]) ? $fields["published"] : null;
        $this->path = empty(slugify($fields["path"])) ? null : slugify($fields["path"]);
        $this->slug = slugify($fields["slug"]) ?: slugify($fields["title"]);
    }


    /**
     * Validate that a string is in the right datetime format.
     *
     * @param string $datetime The datetime string.
     * @return bool If valid or not.
     */
    public function validateDatetime($datetime)
    {
        $dateTimeObj = new \DateTime();
        $dateTimeObj = $dateTimeObj::createFromFormat('Y-m-d H:i:s', $datetime);
        return $dateTimeObj && $dateTimeObj->format('Y-m-d H:i:s') === $datetime;
    }
}
