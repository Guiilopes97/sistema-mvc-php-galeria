<?php

require_once __DIR__ . '/../../config/database.php';

/**
 * Classe Model base
 * Fornece funcionalidades básicas para todos os models
 */
abstract class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Buscar todos os registros
     */
    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Buscar um registro por ID
     */
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        return $this->db->fetch($sql, ['id' => $id]);
    }
    
    /**
     * Buscar registros com condições
     */
    public function where($conditions = [], $orderBy = '', $limit = '') {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        if (!empty($conditions)) {
            $whereParts = [];
            foreach ($conditions as $column => $value) {
                $whereParts[] = "{$column} = :{$column}";
                $params[$column] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $whereParts);
        }
        
        if (!empty($orderBy)) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if (!empty($limit)) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Criar um novo registro
     */
    public function create($data) {
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * Atualizar um registro
     */
    public function update($id, $data) {
        $where = "{$this->primaryKey} = :id";
        $whereParams = ['id' => $id];
        return $this->db->update($this->table, $data, $where, $whereParams);
    }
    
    /**
     * Deletar um registro
     */
    public function delete($id) {
        $where = "{$this->primaryKey} = :id";
        $params = ['id' => $id];
        return $this->db->delete($this->table, $where, $params);
    }
    
    /**
     * Contar registros
     */
    public function count($conditions = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $params = [];
        
        if (!empty($conditions)) {
            $whereParts = [];
            foreach ($conditions as $column => $value) {
                $whereParts[] = "{$column} = :{$column}";
                $params[$column] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $whereParts);
        }
        
        $result = $this->db->fetch($sql, $params);
        return $result['total'];
    }
}
