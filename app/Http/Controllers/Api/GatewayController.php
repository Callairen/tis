<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Log;

class GatewayController extends Controller
{

    private function logActivity(Request $request)
    {
        Log::info("Gateway Access - Method: " . $request->getMethod() . " | Endpoint: " . $request->path() . " | IP: " . $request->ip());
    }

    public function getAdminDashboard(Request $request)
{
    $this->logActivity($request); 
    return response()->json([
        'gateway' => 'API Gateway',
        'message' => 'Welcome to Admin Dashboard via Gateway'
    ]);
}

public function getUserDashboard(Request $request)
{
    $this->logActivity($request); 
    return response()->json([
        'gateway' => 'API Gateway',
        'message' => 'Welcome to User Dashboard via Gateway'
    ]);
}

    
    public function getProfile(Request $request)
{
    $this->logActivity($request); 
    $authController = new AuthController();
    return $authController->profile($request);
}

    
    public function createStudent(Request $request)
    {
        $this->logActivity($request);
        $studentController = new StudentController();
        
        return $studentController->store($request);
    }

    public function getStudents(Request $request)
    {
        $this->logActivity($request);
        $studentController = new StudentController();
        return response()->json([
            'gateway' => 'API Gateway',
            'message' => 'Request forwarded to Student Service',
            'result' => $studentController->index()->getData()
        ]);
    }

    public function updateStudent(Request $request, $nim)
    {
        $this->logActivity($request);
        $studentController = new StudentController();
        return $studentController->update($request, $nim);
    }

    public function deleteStudent($nim)
    {
        Log::info("Gateway Access - Method: DELETE | Endpoint: api/gateway/students/{$nim}");
        $studentController = new StudentController();
        return $studentController->destroy($nim);
    }
}