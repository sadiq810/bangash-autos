<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Notifications\ForgotPasswordNotification;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    /**
     * @return mixed
     * Register new customer.
     */
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'email'      => 'required|unique:customers,email',
            'password'   => 'required|min:5',
            'phone'     => 'required',
            'address'   => 'required'
        ]);

        if ($validator->fails())
            return ['status' => false, 'message' => implode(', ', $validator->getMessageBag()->all())];

        $customer = Customer::create(array_merge(['password' => bcrypt(request()->password)], request()->except(['password'])));
        $customer->city;
        $customer->access_token = Crypt::encryptString($customer->email);
        return ['status' => true, 'data' => $customer];
    }

    /**
     * @return array
     * Login customer.
     */
    public function login()
    {
        $customer = Customer::whereEmail(request()->email)->first();

        if ($customer) {
            if (Hash::check(request()->password, $customer->password)) {
                $customer->city;
                $customer->access_token = Crypt::encryptString($customer->email);
                return ['status' => true, 'data' => $customer];
            }

            return ['status' => false, 'message' => 'Invalid email or password.'];
        }

        return ['status' => false, 'message' => 'Login details not found!'];
    }

    /**
     * @return array
     */
    public function sendNewPassword()
    {
        $customer = Customer::whereEmail(request()->email)->first();
        if ($customer) {
            $newPassword = rand(11111, 99999);
            $customer->password = bcrypt($newPassword);
            $customer->save();
            $customer->notify(new ForgotPasswordNotification($newPassword));

            return ['status' => true, 'message' => 'Email is sent to your provided email with new password, please check your inbox.'];
        }

        return ['status' => false, 'message' => 'Sorry, No record found with this email.'];
    }

    /**
     * @return array
     * Change user password.
     */
    public function changePassword()
    {
        try {
            $email = Crypt::decryptString(request()->hash);
            $user = Customer::whereEmail($email)->first();
            if ($user) {
                $user->password = bcrypt(request()->password);
                $user->save();

                return ['status' => true, 'message' => 'Password changed successfully.'];
            }//..... end if() .....//

            return ['status' => false, 'message' => 'User details not found!.'];
        } catch (\Exception $exception) {
            return ['status' => false, 'message' => 'Internal server error occurred, please try later.'];
        }
    }//..... end of changePassword() .....//

    /**
     * @return array
     * Update user profile.
     */
    public function updateProfile()
    {
        try {
            $email = Crypt::decryptString(request()->hash);
            $user = Customer::whereEmail($email)->first();
            if ($user) {
                $user->fname = request()->fname;
                $user->lname = request()->lname;
                $user->phone = request()->phone;
                $user->address = request()->address;
                if (request()->image)
                    $user->image = $this->uploadBase64Image(request()->image);

                $user->save();

                $user->access_token = Crypt::encryptString($user->email);

                return ['status' => true, 'message' => 'Profile updated successfully.', 'data' => $user];
            }//..... end if() .....//

            return ['status' => false, 'message' => 'User details not found!.'];
        } catch (\Exception $exception) {
            return $exception->getMessage();
            return ['status' => false, 'message' => 'Internal server error occurred, please try later.'];
        }
    }//..... end of updateProfile() .....//

    /**
     * @param $image
     * @return string
     * Upload image.
     */
    private function uploadBase64Image($image)
    {
        try {
            $name = time()*rand(1111, 9999).'.png';
            Image::make($image)->resize(200, 200)->save(public_path('uploads/thumbs/'.$name));
            return $name;
        } catch (\Exception $exception) {
            return '';
        }
    }//..... end of uploadBase64Image() .....//
}
