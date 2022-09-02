<?php
namespace App\Http\Requests;


use App\Database\Models\Contract\Model;

use Error;

class Validation
{
    private string $input;
    private $value;
    private array $errors = [];
    private array $valuestored=[];

    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }
    public function setPassword($password)
    {
        $this->password = password_hash($password,PASSWORD_BCRYPT);
        return $this;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */
    public function setValue($value)
    {
        $this->value = $value;
        $this->valuestored[$this->input] = $value;

        return $this;
    }

    /**
     * Get the value of input
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set the value of input
     *
     * @return  self
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }
    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }
    public function getError(string $input) :?string
    {
        if (isset($this->errors[$input])) {
            foreach ($this->errors[$input] as $error) {
                return $error;
            }
        }
        return null;
    }
    public function getmessage(string $input){
        return "<p class='text-danger font-weight-bold'> ".ucwords(str_replace('_',' ',$this->getError($input)))." </p>";
    }

    /**
     * Set the value of errors
     *
     * @return  self
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }
    public function required()
    {
        if (empty($this->value)) {
            $this->errors[$this->input][__FUNCTION__] = "{$this->input} is required";
        }
        return $this;
    }
    public function max(int $max)
    {
        if (strlen($this->value) > $max) {
            $this->errors[$this->input][__FUNCTION__] = "{$this->input} is must be less than {$max} characters";
        }
        return $this;
    }
    public function min(int $min)
    {
        if (strlen($this->value) < $min) {
            $this->errors[$this->input][__FUNCTION__] = "{$this->input} is must be greater than {$min} characters";
        }
        return $this;
    }
    public function in(array $values)
    {
        if (!in_array($this->value, $values)) {
            $this->errors[$this->input][__FUNCTION__] = "{$this->input} is must be " . implode(',', $values);
        }
        return $this;
    }
    public function regex(string $pattern, string $message = "")
    {
        if (!preg_match($pattern, $this->value)) {
            $this->errors[$this->input][__FUNCTION__] = $message ? $message : "{$this->input} is invalid";
        }
        return $this;
    }
    public function confirmed(string $confirmedValue)
    {
        if(isset($_POST['password']) && $_POST['password'] != $confirmedValue){
            $this->errors[$this->input][__FUNCTION__] = "{$this->input} Not Confirmed";
        }
        return $this;
    }
    public function check()
    {
        if(!password_verify($this->value,$this->password)){
            $this->errors[$this->input][__FUNCTION__] = "{$this->input} Not Correct";
        }
        return $this;
    }
    /**
     * Get the value of valuestored
     */ 
    public function getValuestored(string $input) :? string 
    {
        return $this->valuestored[$input] ?? "";
    }
    public function unique(string $table,string $column="")
    {
        $query = "SELECT * FROM {$table} WHERE {$column} = ?";
        $model = new Model;
        $stmt = $model->conn->prepare($query);
        $stmt->bind_param('s',$this->value);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows >= 1){
            $this->errors[$this->input][__FUNCTION__] = "{$this->input} Already Exists";
        }
        return $this;
    }
    public function exists(string $table,string $column)
    {
        $query = "SELECT * FROM {$table} WHERE {$column} = ?";
        $model = new Model;
        $stmt = $model->conn->prepare($query);
        $stmt->bind_param('s',$this->value);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 0){
            $this->errors[$this->input][__FUNCTION__] = "{$this->input} Not Exists In Our Records";
        }
        return $this;
    }
    public function digits(int $digits){
        if(strlen($this->value) != $digits){
            $this->errors[$this->input][__FUNCTION__] = "{$this->input} the code must be {$digits} numbers";
        }
        return $this;
    }
}
