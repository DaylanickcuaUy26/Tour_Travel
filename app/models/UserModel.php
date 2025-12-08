<?php

require_once ROOT . "/core/Model.php";

class UserModel extends Model
{
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM tblusers WHERE EmailId=:email";
        $query = $this->db->prepare($sql);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function updateUserProfile($email, $name, $mobile)
    {
        $sql =
            "UPDATE tblusers SET FullName=:name,MobileNumber=:mobile WHERE EmailId=:email";
        $query = $this->db->prepare($sql);
        $query->bindParam(":name", $name, PDO::PARAM_STR);
        $query->bindParam(":mobile", $mobile, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        return $query->execute();
    }

    public function checkPassword($email, $password)
    {
        $sql =
            "SELECT Password FROM tblusers WHERE EmailId=:email AND Password=:password";
        $query = $this->db->prepare($sql);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->bindParam(":password", $password, PDO::PARAM_STR);
        $query->execute();
        return $query->rowCount() > 0;
    }

    public function updatePassword($email, $newpassword)
    {
        $sql = "UPDATE tblusers SET Password=:newpassword WHERE EmailId=:email";
        $query = $this->db->prepare($sql);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->bindParam(":newpassword", $newpassword, PDO::PARAM_STR);
        return $query->execute();
    }

    public function checkUserByEmailAndMobile($email, $mobile)
    {
        $sql =
            "SELECT EmailId FROM tblusers WHERE EmailId=:email and MobileNumber=:mobile";
        $query = $this->db->prepare($sql);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->bindParam(":mobile", $mobile, PDO::PARAM_STR);
        $query->execute();
        return $query->rowCount() > 0;
    }

    public function resetPassword($email, $mobile, $newpassword)
    {
        $sql =
            "UPDATE tblusers SET Password=:newpassword WHERE EmailId=:email and MobileNumber=:mobile";
        $query = $this->db->prepare($sql);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->bindParam(":mobile", $mobile, PDO::PARAM_STR);
        $query->bindParam(":newpassword", $newpassword, PDO::PARAM_STR);
        return $query->execute();
    }

    public function checkEmailAvailability($email)
    {
        $sql = "SELECT EmailId FROM tblusers WHERE EmailId=:email";
        $query = $this->db->prepare($sql);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();
        return $query->rowCount() > 0;
    }

    public function createUser($fname, $mnumber, $email, $password)
    {
        $sql =
            "INSERT INTO tblusers(FullName,MobileNumber,EmailId,Password) VALUES(:fname,:mnumber,:email,:password)";
        $query = $this->db->prepare($sql);
        $query->bindParam(":fname", $fname, PDO::PARAM_STR);
        $query->bindParam(":mnumber", $mnumber, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->bindParam(":password", $password, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
}
