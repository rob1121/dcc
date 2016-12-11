<?php namespace App\DCC\Transformer;


class DepartmentTransformer
{
    public function transform(array $collection)
    {

        return [
            "count" => $this->count($collection),
            "active_user" => $collection['user'],
            "department" => $collection['department'],
        ];
    }

    /**
     * @param array $collection
     * @return mixed
     * @internal param array $departments
     */
    private function count(array $collection)
    {
        return collect($collection)->merge($collection)->count();
    }
}