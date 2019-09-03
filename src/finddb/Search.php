<?php

namespace finddb;

class Search
{
    private $db;
    private $campos = ['TABLE_SCHEMA','TABLE_NAME','COLUMN_NAME','COLUMN_TYPE'];
    public $campo;

    public function setDB($db)
    {
        $this->db = $db;
    }

    public function searchData($campo)
    {
        $this->campo = $campo;

        if (empty($this->campo)) {
            return;
        }

        $this->campos = implode(",", $this->campos);

        $query = $this->db->createQueryBuilder();

        $query->select($this->campos)
            ->from('INFORMATION_SCHEMA.COLUMNS', 'data')
            ->where('data.TABLE_SCHEMA = "sogamax" AND data.COLUMN_NAME like "%'.$this->campo.'%"')
            ->orderBy('data.ORDINAL_POSITION', 'ASC');

        $statement = $query->execute();
        $dados = $statement->fetchAll();

        return $dados;
    }
}
