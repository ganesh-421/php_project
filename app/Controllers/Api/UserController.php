<?php 

namespace App\Controllers\Api;

use App\Core\Validator;
use App\Models\Session;
use App\Models\User;
use App\Repositories\AuthRepository;
use App\Transformers\UserTransformer;

class UserController extends BaseApiController
{
    private $repository;

    public function __construct()
    {
        if((new Session)->role() !== 'super_admin')
        {
            return $this->sendError("Unauthorized", 403);
        }
        $this->repository = new AuthRepository();
    }

    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $users = UserTransformer::transformPaginated($this->repository->paginated($page, 5));
        return $this->sendSuccess($users, "List Of Music");
    }

    public function create()
    {
        $vars = file_get_contents("php://input");
        $post_vars = json_decode($vars, true);
        $rules = [
            "first_name" => 'required|min:3|max:255',
            "last_name" => 'required|min:3|max:255',
            "email" => 'required|email|unique:user,email',
            "password" => 'required|min:8|max:15',
            "phone" => 'required|min:10|max:10|unique:user,phone',
            "dob" => 'required|before:today',
            "gender" => 'required|in:m,f,o',
            "address" => 'required|min:3|max:255',
            "role" => 'required|in:super_admin,artist_manager,artist',
        ];
        $data = [
            "first_name" => $post_vars['first_name'],
            "last_name" => $post_vars['last_name'],
            "email" => $post_vars['email'],
            "password" => $post_vars['password'],
            "phone" => $post_vars['phone'],
            "dob" => $post_vars['dob'],
            "gender" => $post_vars['gender'],
            "address" => $post_vars['address'],
            "role" => $post_vars['role'],
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ];
        $validator = new Validator($data, $rules, (new User()));
        if(!$validator->validate()) {
            $errors = $validator->errors();
            return $this->sendError("Validation Error", 422, $errors);
        }

        $result = $this->repository->register($data);
        if($result) {
            return $this->sendSuccess([], "User Added Succesfully");
        } else {
            return $this->sendError("User Couldn't Be Added");
        }
    }

    public function edit()
    {
        $vars = file_get_contents("php://input");
        $post_vars = json_decode($vars, true);
        $id = $post_vars['user_id'];
        $user = (new User())->find($id);
        if(empty($user))
        {
            return $this->sendError("User Not Found", 404);
        }
        $vars = file_get_contents("php://input");
        $post_vars = json_decode($vars, true);
        $data = [
            "first_name" => $post_vars['first_name'] ?? $user['first_name'],
            "last_name" => $post_vars['last_name'] ?? $user['last_name'],
            "email" => $post_vars['email'] ?? $user['email'],
            "password" =>  $post_vars['password'],
            "phone" => $post_vars['phone'] ?? $user['phone'],
            "dob" => $post_vars['dob'] ?? $user['dob'],
            "gender" => $post_vars['gender'] ?? $user['gender'],
            "address" => $post_vars['address'] ?? $user['address'],
            "role" => $post_vars['role'] ?? $user['role'],
            "updated_at" => date('Y-m-d H:i:s'),
        ];
        $rules = [
            "first_name" => 'min:3|max:255',
            "last_name" => 'min:3|max:255',
            "email" => 'email|unique:user,email,id,' . $id,
            "password" => 'min:8|max:15',
            "phone" => 'min:10|max:10|unique:user,phone,id,' . $id,
            "dob" => 'before:today',
            "gender" => 'in:m,f,o',
            "address" => 'min:3|max:255',
            "role" => 'in:super_admin,artist_manager,artist',
        ];
        
        $validator = new Validator($data, $rules, (new User()));
        if(!$validator->validate()) {
            $errors = $validator->errors();
            return $this->sendError("Validation Error", 422, $errors);
        }

        $result = $this->repository->edit($id, $data);
        if($result)
        {
            return $this->sendSuccess([], "User Updated Succesfully");
        } else {
            return $this->sendError("User Couldn't Be Updated");
        }
    }

    public function delete()
    {
        $vars = file_get_contents("php://input");
        $post_vars = json_decode($vars, true);
        $id = $post_vars['user_id'];
        $user = (new User())->find($id);
        if(empty($user))
        {
            return $this->sendError("User Not Found", 404);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if((new Session())->auth()['id'] == $id) {
                return $this->sendError("User Mustn't Delete Themselves");
            }
            $result = $this->repository->delete($id);
            if($result) {
                return $this->sendSuccess([], "User Deleted Succesfully");
            } else {
                return $this->sendError("User Couldn't be Deleted");
            }
        }
    }
}