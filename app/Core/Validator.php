<?php

namespace App\Core;

use DateTime;

class Validator
{
    protected $data = [];
    protected $rules = [];
    protected $errors = [];
    protected $model;

    public function __construct(array $data, array $rules, $model = null)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->model = $model;
    }

    public function validate()
    {
        foreach ($this->rules as $field => $rules) {
            $rulesArray = explode('|', $rules);

            foreach ($rulesArray as $rule) {
                $ruleParams = explode(':', $rule);
                $ruleName = $ruleParams[0];
                $param = $ruleParams[1] ?? null;

                $methodName = 'validate' . ucfirst($ruleName);
                if (method_exists($this, $methodName)) {
                    $this->$methodName($field, $param);
                }
            }
        }
        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    protected function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    protected function validateRequired($field)
    {
        if (empty($this->data[$field])) {
            $this->addError($field, ucfirst($field) . " is required.");
        }
    }

    protected function validateEmail($field)
    {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, ucfirst($field) . " must be a valid email.");
        }
    }

    protected function validateMin($field, $min)
    {
        if (strlen($this->data[$field]) < $min) {
            $this->addError($field, ucfirst($field) . " must be at least $min characters.");
        }
    }

    protected function validateMax($field, $max)
    {
        if (strlen($this->data[$field]) > $max) {
            $this->addError($field, ucfirst($field) . " must be less than $max characters.");
        }
    }

    protected function validateNumeric($field)
    {
        if (!is_numeric($this->data[$field])) {
            $this->addError($field, ucfirst($field) . " must be a number.");
        }
    }

    protected function validateBefore($field, $date)
    {
        $inputDate = new DateTime($this->data[$field]);
        if($date == 'today')
            $compareDate = new DateTime();
        else 
            $compareDate = new DateTime($date);

        if ($inputDate >= $compareDate) {
            $this->addError($field, ucfirst($field) . " must be before $date.");
        }
    }

    protected function validateAfter($field, $date)
    {
        $inputDate = new DateTime($this->data[$field]);
        if($date == 'today')
            $compareDate = new DateTime();
        else 
            $compareDate = new DateTime($date);

        if ($inputDate <= $compareDate) {
            $this->addError($field, ucfirst($field) . " must be after $date.");
        }
    }

    protected function validateUnique($field, $table)
    {
        if ($this->model) {
            $stmt = $this->model->db->prepare("SELECT COUNT(*) FROM $table WHERE $field = ?");
            $stmt->execute([$this->data[$field]]);
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                $this->addError($field, ucfirst($field) . " already exists.");
            }
        }
    }

    protected function validateIn($field, $values)
    {
        $allowedValues = explode(',', $values);
        if (!in_array($this->data[$field], $allowedValues)) {
            $this->addError($field, ucfirst($field) . " must be one of: " . implode(', ', $allowedValues) . ".");
        }
    }

    protected function validateExists($field, $tableColumn)
    {
        if ($this->model) {
            list($table, $column) = explode(',', $tableColumn);
            $stmt = $this->model->db->prepare("SELECT COUNT(*) FROM $table WHERE $column = ?");
            $stmt->execute([$this->data[$field]]);
            $count = $stmt->fetchColumn();
            if ($count == 0) {
                $this->addError($field, "Provided " . ucfirst($field) . " does not exist in $table table.");
            }
        }
    }
}
