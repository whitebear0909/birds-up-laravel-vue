<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Validator;

use App\Models\Property;
use App\Models\Course;

class UserController extends Controller
{
    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:2,20|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function getDashboard()
    {
        $user = auth()->user();
        $properties = Property::where('username', $user->username)->orderBy('propertyName')->get();
        $propertyNames = $properties->pluck('propertyName');

        $chartData = DB::table('huntsummary')
            ->select('propertyName', DB::raw('AVG(coveysMovedHour) as CMH'), DB::raw('AVG(coveysPointedHour) as CPH'), DB::raw('AVG(coveysShotHour) as CSH'))
            ->orderBy('propertyName')
            ->whereIn('propertyName', $propertyNames)
            ->groupBy('propertyName')
            ->get();

        $allProps = DB::table('huntsummary')
            ->select('propertyName', DB::raw('AVG(coveysMovedHour) as CMH'), DB::raw('AVG(coveysPointedHour) as CPH'), DB::raw('AVG(coveysShotHour) as CSH'))
            ->orderBy('propertyName')
            ->whereNotIn('propertyName', $propertyNames)
            ->groupBy('propertyName');
        $allPropChart = DB::table(DB::raw("({$allProps->toSql()}) as a"))
            ->mergeBindings($allProps)
            ->select(DB::raw('AVG(a.CMH) as CMH'), DB::raw('AVG(a.CPH) as CPH'), DB::raw('AVG(a.CSH) as CSH'))
            ->get()->first();

        $boxData1 = DB::table('huntsummary')
            ->select(DB::raw('COUNT(*) as Hunts'), DB::raw('SUM(numHarvested) as BH'))
            ->whereIn('propertyName', $propertyNames)
            ->get()->first();

        $boxData2 = DB::table('huntsummary')
            ->select(DB::raw('SUM(coveysPointedHour) as CP'), DB::raw('SUM(coveysShotHour) as CS'))
            ->whereIn('propertyName', $propertyNames)
            ->get()->first();

        return response()->json([
            'chartData' => $chartData,
            'allPropChart' => $allPropChart,
            'firstBox' => $boxData1,
            'secondBox' => $boxData2
        ]);
    }

    public function getCourseMetrics(Request $request)
    {
        // $property = $request->get('property');
        // $huntType = $request->get('huntType');
        // $course = $request->get('course');
        // $encType = $request->get('encType');
        // $fromDate = $request->get('fromDate');
        // $toDate = $request->get('toDate');

        // $query = array();
        // if($property) array_push($query, ['propertyName', '=', $property]);
        // if($huntType) array_push($query, ['HuntType', '=', $huntType]);
        // if($course) array_push($query, ['course', '=', $course]);
        // // if($encType) array_push($query, ['encType', '=', $encType]);
        // if($fromDate) array_push($query, ['timeStamp', '>=', $fromDate]);
        // if($toDate) array_push($query, ['timeStamp', '<=', $toDate]);

        $user = auth()->user();
        $properties = Property::where('username', $user->username)->orderBy('propertyName')->get();
        $courses = Course::where('username', $user->username)->orderBy('courseName')->get();
        $propertyNames = $properties->pluck('propertyName');
        $courseNames = $properties->pluck('courseName');

        $chartData = DB::table('huntsummary')
            ->select('huntCourse', DB::raw('AVG(coveysMovedHour) as CMH'), DB::raw('AVG(coveysPointedHour) as CPH'), DB::raw('AVG(coveysShotHour) as CSH'))
            ->orderBy('huntCourse')
            // ->where($query)
            // ->whereIn('propertyName', $propertyNames)
            // ->whereIn('huntCourse', $courseNames)
            ->groupBy('huntCourse')
            ->get();
        $boxData = DB::table('huntsummary')
            ->select(DB::raw('SUM(numCP) as CPs'), DB::raw('SUM(numWF) as WFs'), DB::raw('SUM(numHarvested) as BH'))
            // ->whereIn('propertyName', $propertyNames)
            // ->whereIn('huntCourse', $courseNames)
            ->get()->first();
        $tblData = DB::table('genhuntdata')
            ->select('huntID', 'propertyName', 'huntCourse', 'huntParty', 'HuntType', 'skyCover', 'temp', 'wind', 'precip', 'startTime', 'endTime', 'stopTime', 'huntDate', 'maHarv', 'mjHarv', 'faHarv', 'fjHarv')
            // ->whereIn('propertyName', $propertyNames)
            // ->whereIn('huntCourse', $courseNames)
            ->get();
        return response()->json([
            'chartData' => $chartData,
            'boxData' => $boxData,
            'tblData' => $tblData
        ]);
    }

    public function getDogPerformance()
    {

        $tblData = DB::table('dogsummary')
            ->select(DB::raw('dogName as DogName'), DB::raw('date as Date'), DB::raw('groundTimeMins as GroundTime'), DB::raw('numCP as CP'), DB::raw('numSP as SP'), DB::raw('numWF as WF'), DB::raw('numUP as UP'))
            ->get();

        return response()->json([
            'tblData' => $tblData
        ]);
    }

    public function getMapCovey(Request $request)
    {
        $property = $request->get('property');
        $huntType = $request->get('huntType');
        $course = $request->get('course');
        $encType = $request->get('encType');
        // $fromDate = $request->get('fromDate');
        // $toDate = $request->get('toDate');

        $query = array();
        // if($property) array_push($query, ['propertyName', '=', $property]);
        // if($huntType) array_push($query, ['HuntType', '=', $huntType]);
        // if($course) array_push($query, ['course', '=', $course]);
        if ($encType) array_push($query, ['encType', '=', $encType]);
        // if($fromDate) array_push($query, ['timeStamp', '>=', $fromDate]);
        // if($toDate) array_push($query, ['timeStamp', '<=', $toDate]);


        $data = DB::table('huntrecords')->where($query)->get();
        return response()->json([
            'data' => $data
        ]);
    }
}
