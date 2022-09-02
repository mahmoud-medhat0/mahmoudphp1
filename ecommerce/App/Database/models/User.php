<?php

namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class User extends Model implements Crud
{
    private $id, $first_name, $last_name, $email, $password,
        $phone, $gender, $status, $image, $verification_code, $email_verified_at, $created_at, $updated_at,$namen;

    public function create()
    {
        $query = "INSERT INTO users(name_en,email,verification_code,password,gender) VALUES(?,?,?,?,?);";
        $name = $this->first_name . "_" . $this->last_name;
        $state = $this->conn->prepare($query);
        $state->bind_param("sssss", $name, $this->email, $this->verification_code, $this->password, $this->gender);
        $state->execute();
        $query0 = "SELECT `id` FROM users WHERE email = ?";
        $state0 = $this->conn->prepare($query0);
        $state0->bind_param("s", $this->email);
        $state0->execute();
        $result = $state0->get_result()->fetch_all();
        $userid = $result['0']['0'];
        $query1 = "INSERT INTO user_phone(user_id,phone) VALUES(?,?)";
        $state1 = $this->conn->prepare($query1);
        $state1->bind_param("is", $userid, $this->phone);
        return  $state1->execute();
    }
    public function read()
    {
        # code...
    }
    public function setValue($value)
    {
        $this->value = $value;
        $this->valuestored[$this->input] = $value;

        return $this;
    }

    public function update()
    {
        $query = "UPDATE users SET `$this->input` = ? WHERE email = ?";
        $state = $this->conn->prepare($query);
        $state->bind_param("ss",$this->value, $this->email);
        return $state->execute();
    }
    public function updatepass()
    {
        $query = "UPDATE users SET `$this->input` = ? WHERE email = ?";
        $state = $this->conn->prepare($query);
        $state->bind_param("ss",$this->value, $this->email);
        return $state->execute();
    }
    public function updatephone()
    {
        $query = "UPDATE user_phone SET `$this->input` = ? WHERE user_id = ?";
        $state = $this->conn->prepare($query);
        $state->bind_param("si",$this->value, $this->id);
        return $state->execute();
    }
    public function delete()
    {
        # code...
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
    public function updateImage()
    {
        $query = "UPDATE users SET image = ? WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss',$this->image,$this->email);
        return $stmt->execute();
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of first_name
     */
    public function getFirst_name()
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     *
     * @return  self
     */
    public function setFirst_name($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of last_name
     */
    public function getLast_name()
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */
    public function setLast_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password,PASSWORD_BCRYPT);
        return $this;
    }

    /**
     * Get the value of phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }
    public function updateGender()
    {
        $query = "UPDATE users SET gender = ? WHERE email = ?";
        $state = $this->conn->prepare($query);
        $state->bind_param("ss",$this->gender,$this->email);
        return $state->execute();
    } 

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of verification_code
     */
    public function getVerification_code()
    {
        return $this->verification_code;
    }

    /**
     * Set the value of verification_code
     *
     * @return  self
     */
    public function setVerification_code($verification_code)
    {
        $this->verification_code = $verification_code;

        return $this;
    }

    /**
     * Get the value of email_verified_at
     */
    public function getEmail_verified_at()
    {
        return $this->email_verified_at;
    }

    /**
     * Set the value of email_verified_at
     *
     * @return  self
     */
    public function setEmail_verified_at($email_verified_at)
    {
        $this->email_verified_at = $email_verified_at;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
    public function checkcode()
    {
        $query = "SELECT `verification_code` FROM users WHERE email = ? AND verification_code = ?";
        $state = $this->conn->prepare($query);
        $state->bind_param("si",$this->email, $this->verification_code);
        $state->execute();
        return $state->get_result();
    }   
    public function makeverified()
    {
        $query = "UPDATE users SET email_verified_at = ? WHERE email = ?";
        $state = $this->conn->prepare($query);
        $state->bind_param("ss",$this->email_verified_at, $this->email);
        return $state->execute();
    } 
    public function getuser()
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $state = $this->conn->prepare($query);
        $state->bind_param("s",$this->email);
        $state->execute();
        return $state->get_result();
    } 
    public function getuserbyid(int $id)
    {
        $query = "SELECT * FROM user_phone WHERE user_id = ?";
        $state = $this->conn->prepare($query);
        $state->bind_param('i',$id);
        $state->execute();
        return $state->get_result();
    } 
    public function makeUserVerified()
    {
        $query = "UPDATE users SET email_verified_at = ? WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss',$this->email_verified_at,$this->email);
        return $stmt->execute();
    }
    public function updateCode()
    {
        $query = "UPDATE users SET verification_code = ? WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss',$this->verification_code,$this->email);
        return $stmt->execute();
    }
    public function updateassword()
    {
        $query = "UPDATE users SET `password` = ? WHERE email = ?";
        $state = $this->conn->prepare($query);
        $state->bind_param("ss",$this->password, $this->email);
        return $state->execute();
    }


        /**
         * Get the value of namen
         */ 
        public function getNamen()
        {   $query = "SELECT * FROM users WHERE email = ?";
            $state = $this->conn->prepare($query);
            $state->bind_param('s',$this->email);
            $state->execute();
            return $state->get_result();
        }

        /**
         * Set the value of namen
         *
         * @return  self
         */ 
        public function setNamen($namen)
        {
                $this->namen = $namen;

                return $this;
        }
}
