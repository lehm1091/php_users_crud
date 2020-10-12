<?php

require_once('connection.php');
require_once('role.php');
class roleRepository
{




    public function roleEncode($roleRecord)
    {
        $role = new role();
        $role->role_id = $roleRecord['role_id'];
        $role->name = $roleRecord['name'];
        return $role;
    }


    public function findRoleByName($name)
    {

        $db = Connection::connect();
        $select = $db->prepare('SELECT * FROM roles where name=:name');
        $select->bindValue("name", $name);
        $select->execute();
        $item = $select->fetch();
        if ($item) {
            return $this->roleEncode($item);
        }
    }



    public function findRolesByUserId($id)
    {
        try {
            $db = Connection::connect();
            $select = $db->prepare('SELECT r.role_id,r.name FROM roles as r inner join users_roles ur on r.role_id=ur.role_id where ur.user_id=:id');
            $select->bindValue("id", $id);
            $select->execute();
            if (isset($select)) {
                foreach ($select->fetchAll() as $role) {
                    $roles[] = $this->roleEncode($role);
                }
            } else {
                return array();
            }
        } catch (Exception $e) {
            printError(500, $e->getMessage() . "<br>");
        }
    }


    public function deleteRolesByUserId($id)
    {

        $db = Connection::connect();
        $select = $db->prepare('DELETE FROM users_roles where user_id=:user_id ');
        $select->bindValue("user_id", $id);
        $select->execute();
    }

    public function addRoleToUser($user_id, $role_id)
    {
        try {
            $db = Connection::connect();
            $select = $db->prepare('INSERT INTO users_roles values(:user_id,:role_id)');
            $select->bindValue("user_id", $user_id);
            $select->bindValue("role_id", $role_id);
            if ($select->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            printError(500, $e->getMessage() . "<br>");
        }
    }
}
