<?php

namespace Code\DB;

use \PDO;

abstract class Entity
{
    private $conn;
    protected $tabela;

    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function where(array $condicoes, $operador = ' AND ', $campos = '*')
    {
        $sql = 'SELECT ' . $campos . ' FROM ' . $this->tabela .  ' WHERE ';
        $binds = array_keys($condicoes);
        $where = null;
        foreach ($binds as $v) {
            if (is_null($where)) {
                $where .= $v . ' = :' . $v;
            } else {
                $where .= $operador . $v . ' = :' . $v;
            }
        }
        $sql .= $where;
        $get = $this->bind($sql, $condicoes);
        $get->execute();
        if ($get->rowCount() > 1) {
            return $get->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return $get->fetch(\PDO::FETCH_ASSOC);
        }
    }
    public function whereJoin(string $tabela1, string $tabela2, string $whereJoin, array $condicoes, $campos = '*', $operador = ' AND ',$order = ' id ')
    {
        $sql = 'SELECT ' . $campos . ' FROM ' . $tabela1 . ' A LEFT JOIN ' . $tabela2 . ' B ON ' . $whereJoin . ' WHERE ';
        $binds = array_keys($condicoes);
        $where = null;
        foreach ($binds as $v) {
            if (is_null($where)) {
                $where .= $v . ' = :' . $v;
            } else {
                $where .= $operador . $v . ' = :' . $v;
            }
        }
        $sql .= $where . ' ORDER BY ' . $order . ' ASC';
        $get = $this->bind($sql, $condicoes);
        $get->execute();
        return $get->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function whereLista(array $condicoes = null, $operador = ' AND ', $campos = ' * ', $comparacao = " = ", $order = " id ")
    {
        if ($condicoes) {
            $sql = 'SELECT ' . $campos . ' FROM ' . $this->tabela .  ' WHERE ';
            $binds = array_keys($condicoes);
            $where = null;
            foreach ($binds as $v) {
                if (is_null($where)) {
                    $where .= $v . $comparacao . ' :' . $v;
                } else {
                    $where .= $operador . $v . $comparacao . ' :' . $v;
                }
            }
            $sql .= $where . ' ORDER BY ' . $order . ' ASC';
            $resultado = $this->bind($sql, $condicoes);
            $resultado->execute();
        } else {
            $sql = 'SELECT ' . $campos . ' FROM ' . $this->tabela . " ORDER BY " . $order . " ASC";
            $resultado = $this->conn->query($sql);
        }
        return $resultado->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert(array $data)
    {
        $binds = array_keys($data);
        $sql = 'INSERT INTO ' . $this->tabela . '(' . implode(', ', $binds) . ',created_at,updated_at) VALUES(:' . implode(', :', $binds) . ',NOW(),NOW())';
        $insert = $this->bind($sql, $data);
        return $insert->execute();
    }

    public function update(array $data)
    {
        $bind = array_keys($data);
        $sql = 'UPDATE ' . $this->tabela . ' SET ';
        $set = null;
        foreach ($bind as $v) {
            if ($v != $bind[0]) {
                if (is_null($set)) {
                    $set .= $v . ' = :' . $v;
                } else {
                    $set .= ' , ' . $v . ' = :' . $v;
                }
            }
        }
        $sql .= $set . ', updated_at = NOW() WHERE ' . $bind[0] . ' = :' . $bind[0];
        $update = $this->bind($sql, $data);
        return $update->execute();
    }

    public function delete(array $where)
    {
        $sql = 'DELETE FROM ' . $this->tabela . ' WHERE ' . array_keys($where) . ' =:' . array_keys($where);
        $delete = $this->bind($sql, $where);
        return $delete->execute();
    }

    private function bind($sql, $data)
    {
        $bind = $this->conn->prepare($sql);
        foreach ($data as $k => $v) {
            gettype($v) == 'int' ? $bind->bindValue(':' . $k, $v, \PDO::PARAM_INT)
                : $bind->bindValue(':' . $k, $v, \PDO::PARAM_STR);
        }
        return $bind;
    }
}