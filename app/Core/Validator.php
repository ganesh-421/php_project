<?php

namespace App\Core;

use DateTime;

class Validator
{
    /**
     * @var array data to be validated
     */
    protected $data = [];

    /**
     * @var array rules for validation
     */
    protected $rules = [];

    /**
     * @var array errors for validation result
     */
    protected $errors = [];

    /**
     * @var object model for which data to be validated
     */
    protected $model;

    /**
     * instantiate validator class
     * @param array 
     * @param array
     * @param object
     */
    public function __construct(array $data, array $rules, $model = null)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->model = $model;
    }

    /**
     * Validates given field according to rule
     */
    public function validate(): bool
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

    /**
     * returns all errors obtained after validation
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * add validation error in the list
     */
    protected function addError($field, $message): void
    {
        $this->errors[$field][] = $message;
    }

    /**
     * validation for required rule
     * @param string
     */
    protected function validateRequired($field): void
    {
        if (empty($this->data[$field])) {
            $this->addError($field, ucfirst($field) . " is required.");
        }
    }

    /**
     * validation for email rule
     * @param string
     */
    protected function validateEmail($field): void
    {
        if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, ucfirst($field) . " must be a valid email.");
        }
    }

    /**
     * validation for min rule
     * @param string
     * @param string|int
     */
    protected function validateMin($field, $min): void
    {
        if (strlen($this->data[$field]) < $min) {
            $this->addError($field, ucfirst($field) . " must be at least $min characters.");
        }
    }

    /**
     * validation for max rule
     * @param string
     * @param string|int
     */
    protected function validateMax($field, $max): void
    {
        if (strlen($this->data[$field]) > $max) {
            $this->addError($field, ucfirst($field) . " must be less than $max characters.");
        }
    }

    /**
     * validation for numeric rule
     * @param string
     */
    protected function validateNumeric($field): void
    {
        if (!is_numeric($this->data[$field])) {
            $this->addError($field, ucfirst($field) . " must be a number.");
        }
    }

    /**
     * validation for before rule
     * @param string
     * @param string
     */
    protected function validateBefore($field, $date): void
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

    /**
     * validation for after rule
     * @param string
     * @param string
     */
    protected function validateAfter($field, $date): void
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

    /**
     * validation for unique rule
     * @param string
     * @param string
     */
    protected function validateUnique($field, $params): void
    {
        if ($this->model) {
            list($table, $column, $ignoreColumn, $ignore) = explode(',', $params);
            if(!empty($ignoreColumn) && !empty($ignore))
            {
                $stmt = $this->model->db->prepare("SELECT COUNT(*) FROM $table WHERE $field = ? AND $ignoreColumn <> ?");
                $stmt->execute([$this->data[$field], $ignore]);
            } else {
                $stmt = $this->model->db->prepare("SELECT COUNT(*) FROM $table WHERE $field = ?");
                $stmt->execute([$this->data[$field]]);
            }
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                $this->addError($field, ucfirst($field) . " already exists.");
            }
        }
    }

    /**
     * validation for in rule
     * @param string
     * @param string
     */
    protected function validateIn($field, $values): void
    {
        $allowedValues = explode(',', $values);
        if (!in_array($this->data[$field], $allowedValues)) {
            $this->addError($field, ucfirst($field) . " must be one of: " . implode(', ', $allowedValues) . ".");
        }
    }

    /**
     * validation for exists rule
     * @param string
     * @param string
     */
    protected function validateExists($field, $tableColumn): void
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
