<?php

namespace App\Interfaces;

interface IModel{
    public static function findById(int $id): ?IModel;
    public function save(): bool;
}