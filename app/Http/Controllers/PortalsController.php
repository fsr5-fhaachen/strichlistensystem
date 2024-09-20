<?php

namespace App\Http\Controllers;

use App\Models\Person;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class PortalsController extends Controller
{
    /**
     * Validate request
     *
     * @param string $password
     * @return boolean
     */
    public function validateRequest(string $password){
        return $password == env('APP_PORTALS_IMPORT_PW');
    }

    /**
     * validate auth token
     *
     * @param  Request $request
     * 
     * @return JsonResponse
     */
    public function importUsers(Request $request)
    {
        if (!$this->validateRequest($request->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // if "deleteUsers" url parameter is set to true, all users that are not in the import anymore will be deleted
        $deleteUsers = ($request->deleteUsers == 'true');

        // build url
        $url = '';
        if (str_ends_with(env('APP_PORTALS_URL'), '/')) {
            $url = env('APP_PORTALS_URL') . 'api/v1/users';
        } else {
            $url = env('APP_PORTALS_URL') . '/api/v1/users';
        }

        // call APP_PORTALS_URL
        $client = new Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => env('APP_PORTALS_API_SECRET')
            ]
        ]);

        // get status code
        $statusCode = $response->getStatusCode();

        if($statusCode != 200) {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => $statusCode
            ], 401);
        }

        // get body
        $body = $response->getBody()->getContents();

        // get users
        $users = json_decode($body, true)['users'];

        // save all removed and added users
        $removedUsers = [];
        $addedUsers = [];
        $updatedUsers = [];
        $doNotRemovePersonIds = [];

        // loop through users
        foreach($users as $user) {
            // check if Person with id exists if not create new Person
            $person = Person::firstOrNew(['id' => $user['id']]);
            
            array_push($doNotRemovePersonIds, $user['id']);

            // set attributes
            if($person->id == null) {
                // this could be a problem if the id is/was used by a another person that was created/imported before
                // because we handle the complete user management via portals import and do not manage persons manually here, this is not a problem
                $person->id = $user['id'];
                array_push($addedUsers, $user['id'] . " (" . $user['email'] . ")");
            } else {
                if ($person->email == $user['email']) {
                    array_push($updatedUsers, $person->id . " (" . $person->email . ")");
                } else {
                    array_push($updatedUsers, $person->id . " (" . $person->email . " - " . $user['email'] . ")");
                }
            }
            $person->firstname = $user['firstname'];
            $person->lastname = $user['lastname'];
            $person->email = $user['email'];

            // check if course is set
            if(isset($user['course'])) {
                $abbreviation = strtoupper($user['course']['abbreviation']);

                // add fallbacks for other courses if abbreviation is not INF, ET, WI, DIB or MCD
                if(!in_array($abbreviation, ['INF', 'ET', 'WI', 'DIB', 'MCD'])) {
                    if($abbreviation == 'SBE') {
                        $abbreviation = 'ET';
                    } else if($abbreviation == 'ET-MASTER') {
                        $abbreviation = 'ET';
                    } else if($abbreviation == 'ISE-MASTER') {
                        $abbreviation = 'INF';
                    } else {
                        $abbreviation = 'INF';
                    }
                }

                $person->course = $abbreviation;
            }

            // import image path, if null set empty string
            if (isset($user['avatar'])) {
                $person->img = $user['avatar'];
            } else {
                $person->img = "";
            }

            // check roles
            $roles = $user['roles'];

            // loop through roles
            foreach($roles as $role) {
                // check if role is tutor
                if($role['name'] == 'tutor') {
                    $person->is_tutor = true;
                }
                // check if role is special
                if($role['name'] == 'special') {
                    $person->is_special = true;
                }
            }

            // set is_disabled
            $person->is_disabled = $user['is_disabled'];

            // save Person
            $person->save();
        }

        if ($deleteUsers) {
            $deletePersons = Person::whereNotIn('id', $doNotRemovePersonIds)->get();
            foreach($deletePersons as $person) {
                $person->delete();
                array_push($removedUsers, $person->id . " (" . $person->email . ")");
            }
        }

        // return response
        return response()->json([
            'message' => 'User imported',
            'status' => $statusCode,
            'addedUsers' => $addedUsers,
            'removedUsers' => $removedUsers,
            'updatedUsers' => $updatedUsers
        ], 200);
    }
}
