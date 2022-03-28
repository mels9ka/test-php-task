<?php

namespace services\db;

interface DBConnection
{
    public function get();

    public function query($params);

    function create($params);
}