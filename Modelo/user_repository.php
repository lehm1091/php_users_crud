<?php

require_once('connection.php');
require_once('user.php');
require_once('role_repository.php');
class UserRepository
{




    public function userEncode($userRecord, $roles)
    {
        $user = new User();
        $user->user_id = $userRecord['user_id'];
        $user->email = $userRecord['email'];
        $user->password = $userRecord['password'];
        $user->first_name = $userRecord['first_name'];
        $user->last_name = $userRecord['last_name'];
        $user->tel_number = $userRecord['tel_number'];
        $user->last_seen = $this->formatDate($userRecord['last_seen']);
        $user->create_at = $this->formatDate($userRecord['create_at']);
        $user->is_active = $userRecord['is_active'];
        $user->roles = $roles;
        return $user;
    }

    private function formatDate($myqldate)
    {
        return  date('d-m-yy H:i', strtotime($myqldate));
    }



    public function saveUser(User $user)
    {
        try {
            $db = Connection::connect();
            $insert = $db->prepare('INSERT INTO users(user_id,email,password,first_name,last_name,tel_number) values(null,:email,:password,:first_name,:last_name,:tel_number)');
            if (!empty($user->password)) {
                $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
            }
            $insert->bindValue('email', $user->email);
            $insert->bindValue('password', $hashedPassword);
            $insert->bindValue('first_name', $user->first_name);
            $insert->bindValue('last_name', $user->last_name);
            $insert->bindValue('tel_number', $user->tel_number);
            if ($insert->execute()) {
                return $db->lastInsertId();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            printError(500, $e->getMessage() . "<br>");
        }
    }

    public function updateUser(User $user)
    {
        try {
            $db = Connection::connect();
            $insert = $db->prepare('UPDATE  users SET email=:email ,password = :password ,first_name  = :first_name ,last_name =  :last_name,tel_number = :tel_number WHERE user_id=:user_id');
            if (!empty($user->password)) {
                $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
            }
            $insert->bindValue('email', $user->email);
            $insert->bindValue('password', $hashedPassword);
            $insert->bindValue('first_name', $user->first_name);
            $insert->bindValue('last_name', $user->last_name);
            $insert->bindValue('tel_number', $user->tel_number);
            $insert->bindValue('user_id', $user->user_id);
            if ($insert->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            printError(500, $e->getMessage() . "<br>");
        }
    }



    public function findUserByEmail($email)
    {
        try {
            $db = Connection::connect();
            $select = $db->prepare('SELECT * FROM users where email=:email');
            $select->bindValue("email", $email);
            $select->execute();
            $item = $select->fetch();
            if ($item) {
                $roleRepository = new roleRepository();
                return $this->userEncode($item, $roleRepository->findRolesByUserId($item['user_id']));
            }
        } catch (Exception $e) {
            printError(500, $e->getMessage() . "<br>");
        }
    }


    public function findUserById($id)
    {
        try {
            $db = Connection::connect();
            $select = $db->prepare('SELECT * FROM users where user_id=:id');
            $select->bindValue("id", $id);
            $select->execute();
            $item = $select->fetch();
            if ($item) {
                $roleRepository = new roleRepository();
                return $this->userEncode($item, $roleRepository->findRolesByUserId($item['user_id']));
            }
        } catch (Exception $e) {
            printError(500, $e->getMessage() . "<br>");
        }
    }


    public function userEmailExist($email)
    {
        try {
            if ($this->findUserByEmail($email)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            printError(500, $e->getMessage() . "<br>");
        }
    }


    public function updateUserLastSeen($id)
    {
        try {
            $db = Connection::connect();
            $insert = $db->prepare('UPDATE  users SET last_seen = now() WHERE user_id=:user_id');
            $insert->bindValue('user_id', $id);
            if ($insert->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            printError(500, $e->getMessage() . "<br>");
        }
    }

    public function userHasAccess($password, $email)
    {
        if ($this->userEmailExist($email)) {
            $userRecord = $this->findUserByEmail($email);
            if (password_verify($password, $userRecord->password)) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function findAllUsers()
    {
        $users = [];
        try {
            $db = Connection::connect();
            $select = $db->query('SELECT * FROM  users');
            foreach ($select->fetchAll() as $user) {
                $roleRepository = new roleRepository();
                $users[] = $this->userEncode($user, $roleRepository->findRolesByUserId($user['user_id']));;
            }
            return $users;
        } catch (PDOException $e) {
            printError(500, $e->getMessage());
        }
    }


    public function deleteUserById($id)
    {

        try {
            $db = Connection::connect();
            $select = $db->prepare('DELETE FROM users where user_id=:user_id ');
            $select->bindValue("user_id", $id);
            return $select->execute();
        } catch (PDOException $e) {
            printError(500, $e->getMessage());
        }
    }
}
