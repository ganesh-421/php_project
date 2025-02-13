<?php 

namespace App\Controllers;

use App\Repositories\AuthRepository;

class UserController
{
    private $repository;

    public function __construct()
    {
        if(!$_SESSION['user_id'])
        {
            $_SESSION['error'] = "Session Expired";
            header("Location: /login");
            exit;
        }

        if($_SESSION['role'] !== 'super_admin')
        {
            $_SESSION['error'] = "Unauthorized.";
            header("Location: /");
            exit;
        }
        $this->repository = new AuthRepository();
    }

    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $users = $this->repository->paginated($page, 5);
        require_once __DIR__ . '/../Views/auth/user/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "email" => $_POST['email'],
                "password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
                "phone" => $_POST['phone'],
                "dob" => $_POST['dob'],
                "gender" => $_POST['gender'],
                "address" => $_POST['address'],
                "role" => $_POST['role'],
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $result = $this->repository->register($data);
            if($result) {
                $_SESSION['success'] = "User Created Succesfully";
                header("Location: /users");
                exit;
            } else {
                // $_SESSION['error'] = "User Couldn't be Created";
                header("Location: /create/user");
                exit;
            }
        } else {
            require_once __DIR__ . '/../Views/auth/user/create.php';
        }
    }

    public function edit()
    {
        $id = $_REQUEST['user_id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "email" => $_POST['email'],
                "password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
                "phone" => $_POST['phone'],
                "dob" => $_POST['dob'],
                "gender" => $_POST['gender'],
                "address" => $_POST['address'],
                "role" => $_POST['role'],
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $result = $this->repository->edit($id, $data);
            if($result)
            {
                $_SESSION['success'] = "User Updated Succesfully";
                header("Location: /users");
                exit;
            } else {
                // $_SESSION['error'] = "User Couldn't be Updated";
                header("Location: /update/user?user_id=".$id);
                exit;
            }
        } else {
            $user = $this->repository->findBy(['id' => $id])[0];
            require_once __DIR__ . '/../Views/auth/user/edit.php';
        }
    }

    public function delete()
    {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->repository->delete($_POST['user_id']);
            if($result) {
                $_SESSION['success'] = "User deleted succesfully";
                header("Location: /users");
                exit;
            } else {
                $_SESSION['error'] = "User Couldn't be Deleted";
                header("Location: /users");
                exit;
            }
        }
    }
}