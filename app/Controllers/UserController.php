<?php 

namespace App\Controllers;

use App\Core\Validator;
use App\Models\Session;
use App\Models\User;
use App\Repositories\AuthRepository;

class UserController
{
    private $repository;

    public function __construct()
    {
        if((new Session)->role() !== 'super_admin')
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
            $rules = [
                "first_name" => 'required|min:3|max:255',
                "last_name" => 'required|min:3|max:255',
                "email" => 'required|email|unique:user,email',
                "password" => 'required|min:8|max:15',
                "phone" => 'required|min:10|max:10|unique:user,phone',
                "dob" => 'required|before:today',
                "gender" => 'required|in:m,f,o',
                "address" => 'required|min:3|max:255',
                "role" => 'required|in:super_admin,admin,artist',
            ];
            $data = [
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "email" => $_POST['email'],
                "password" => $_POST['password'],
                "phone" => $_POST['phone'],
                "dob" => $_POST['dob'],
                "gender" => $_POST['gender'],
                "address" => $_POST['address'],
                "role" => $_POST['role'],
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $validator = new Validator($data, $rules, (new User()));
            if(!$validator->validate()) {
                $errors = $validator->errors();
                $_SESSION['errors'] = $errors;
                header("Location: /create/user");
                exit;
            }
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
        $user = (new User())->find($id);
        if(empty($user))
        {
            $_SESSION['error'] = "User Not Found";
            header("Location: /users");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $rules = [
                "first_name" => 'min:3|max:255',
                "last_name" => 'min:3|max:255',
                "email" => 'required|email|unique:user,email,id,' . $id,
                "password" => 'min:8|max:15',
                "phone" => 'min:10|max:10|unique:user,phone',
                "dob" => 'before:today',
                "gender" => 'in:m,f,o',
                "address" => 'min:3|max:255',
                "role" => 'in:super_admin,admin,artist',
            ];
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
        $id = $_REQUEST['user_id'];
        $user = (new User())->find($id);
        if(empty($user))
        {
            $_SESSION['error'] = "User Not Found";
            header("Location: /users");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if((new Session())->auth()['id'] == $id) {
                $_SESSION['error'] = "Users Shouldn't delete themselves";
                header("Location: /users");
                exit;
            }
            $result = $this->repository->delete($id);
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