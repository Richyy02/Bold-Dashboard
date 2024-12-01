<?php

namespace App\View;

class test
{
    public static $_name = "ik";
    protected string $name;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return view('php.blade.php', ['name' => $this->name]);
    }

    /**
     * @return $this
     */
    public function mutate(): self
    {
        $this->name = $this->name . " is cool";
        return $this;
    }
}


