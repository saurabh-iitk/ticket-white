<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::where('id', 1)->first();

        return view('auth.user.setting.index', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::where('id', $id)->first();
        if ($request->has('general_setting') && ($request->general_setting == 'general_setting')) {
            $setting->site_title = $request->site_title;
            $setting->home_title = $request->home_title;
            $setting->copyright = $request->copyright;
            $setting->mobile_mandatory = $request->mobile_mandatory;
            
            if($request->hasFile('ticket_logo'))
            {
                $file = $request->file('ticket_logo');
                $file_name=pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
                //$extension=pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);
                $extension = $file->extension() ?: 'png';
                $ticket_logo = $file_name . uniqid() . '.' . $extension;
                $destinationPath = public_path() . '/uploads/events/banner';
                $file->move($destinationPath, $picture);
            }
            else
            {
                $ticket_logo='';
            }
        
            $setting->ticket_logo = $ticket_logo;
            
            
            
            if($request->hasFile('main_banner'))
            {
                $file = $request->file('main_banner');
                $file_name=pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
                //$extension=pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);
                $extension = $file->extension() ?: 'png';
                $main_banner = $file_name . uniqid() . '.' . $extension;
                $destinationPath = public_path() . '/uploads/events/banner';
                $file->move($destinationPath, $picture);
            }
            else
            {
                $main_banner='';
            }
        
            $setting->main_banner = $main_banner;
            
            $setting->save();

            return redirect('/setting?tab=general-setting')->with('success', 'Setting successfully updated!');
        }

        if ($request->has('contact_setting') && ($request->contact_setting == 'contact_setting')) {
            $setting->contact_address = $request->contact_address;
            $setting->contact_email = $request->contact_email;
            $setting->contact_phone = $request->contact_phone;

            $setting->save();

            return redirect('/setting?tab=contact-setting')->with('success', 'Setting successfully updated!');
        }

        if ($request->has('social_media_setting') && ($request->social_media_setting == 'social_media_setting')) {
            $setting->facebook_url = $request->facebook_url;
            $setting->twitter_url = $request->twitter_url;
            $setting->google_url = $request->google_url;
            $setting->instagram_url = $request->instagram_url;
            $setting->pinterest_url = $request->pinterest_url;
            $setting->linkedin_url = $request->linkedin_url;
            $setting->vk_url = $request->vk_url;
            $setting->youtube_url = $request->youtube_url;

            $setting->save();

            return redirect('/setting?tab=social-media-setting')->with('success', 'Setting successfully updated!');
        }

        if ($request->has('email_setting') && ($request->email_setting == 'email_setting')) {
            $setting->mail_protocol = $request->mail_protocol;
            $setting->mail_title = $request->mail_title;
            $setting->mail_host = $request->mail_host;
            $setting->mail_port = $request->mail_port;
            $setting->mail_username = $request->mail_username;
            $setting->mail_password = $request->mail_password;

            $setting->save();

            return redirect('/setting?tab=email-setting')->with('success', 'Setting successfully updated!');
        }
    }
}