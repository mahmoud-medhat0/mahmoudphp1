<?php
$query = "INSERT INTO users(name_en,email,verification_code,password,gender) VALUES(?,?,?,?,?);";
$name = $this->first_name . " " . $this->last_name;
$state = $this->conn->prepare($query);
$state->bind_param("sssis", $name, $this->email, $this->verification_code, $this->password, $this->gender);
//return $state1->execute();
$state->execute();
$query0 = "SELECT `id` FROM users WHERE id = ?";
$query1 = "INSERT INTO user_phone(phone) VALUES(?)";
$state1 = $this->conn->prepare($query1);
$state1->bind_param("s", $this->phone);
