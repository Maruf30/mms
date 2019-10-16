<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Group;
use App\Member;

use Carbon\Carbon;
use DB, Hash, Auth, Image, File, Session;
use Purifier;

class MemberController extends Controller
{
    public function getMembers($s_id, $g_id)
    {
    	$staff = User::find($s_id);
    	$group = Group::find($g_id);
        $members = Member::where('group_id', $g_id)
        				 ->orderBy('id', 'asc')->get();
        return view('dashboard.groups.members.index')
        					->withStaff($staff)
        					->withGroup($group)
        					->withMembers($members);
    }

    public function createMember($s_id, $g_id)
    {
    	$staff = User::find($s_id);
    	$group = Group::find($g_id);
      return view('dashboard.groups.members.create')
      					->withStaff($staff)
      					->withGroup($group);
    }

    public function storeMember(Request $request, $s_id, $g_id)
    {
        $this->validate($request, [
          'passbook'              => 'required',
          'name'                  => 'required',
          'fhusband'              => 'required',
          'ishusband'             => 'required',
          'mother'                => 'required',
          'gender'                => 'required',
          'marital_status'        => 'required',
          'religion'              => 'required',
          'ethnicity'             => 'required',
          'guardian'              => 'required',
          'guardianrelation'      => 'required',
          'residence_type'        => 'sometimes',
          'landlord_name'         => 'sometimes',
          'education'             => 'required',
          'profession'            => 'required',
          'dob'                   => 'required',
          'nid'                   => 'required',
          'admission_date'        => 'required',
          'closing_date'          => 'sometimes',

          'present_district'      => 'required',
          'present_upazilla'      => 'required',
          'present_union'         => 'required',
          'present_post'          => 'required',
          'present_village'       => 'required',
          'present_house'         => 'required',
          'present_phone'         => 'required',

          'permanent_district'    => 'required',
          'permanent_upazilla'    => 'required',
          'permanent_union'       => 'required',
          'permanent_post'        => 'required',
          'permanent_village'     => 'required',
          'permanent_house'       => 'required',
          'permanent_phone'       => 'sometimes',
        ]);

        $member = new Member;
        $member->passbook = $request->passbook;
        $member->name = $request->name;
        $member->fhusband = $request->fhusband;
        $member->ishusband = $request->ishusband;
        $member->mother = $request->mother;
        $member->gender = $request->gender;
        $member->marital_status = $request->marital_status;
        $member->religion = $request->religion;
        $member->ethnicity = $request->ethnicity;
        $member->guardian = $request->guardian;
        $member->guardianrelation = $request->guardianrelation;
        $member->residence_type = $request->residence_type;
        $member->landlord_name = $request->landlord_name;
        $member->education = $request->education;
        $member->profession = $request->profession;
        $member->dob = date('Y-m-d', strtotime($request->dob));
        $member->nid = $request->nid;
        $member->admission_date = date('Y-m-d', strtotime($request->admission_date));
        if($request->closing_date) {
          $member->closing_date = date('Y-m-d', strtotime($request->closing_date));
        }
        $member->present_district = $request->present_district;
        $member->present_upazilla = $request->present_upazilla;
        $member->present_union = $request->present_union;
        $member->present_post = $request->present_post;
        $member->present_village = $request->present_village;
        $member->present_house = $request->present_house;
        $member->present_phone = $request->present_phone;

        $member->permanent_district = $request->permanent_district;
        $member->permanent_upazilla = $request->permanent_upazilla;
        $member->permanent_union = $request->permanent_union;
        $member->permanent_post = $request->permanent_post;
        $member->permanent_village = $request->permanent_village;
        $member->permanent_house = $request->permanent_house;
        $member->permanent_phone = $request->permanent_phone;

        $member->status = 1; // auto active
        $member->group_id = $g_id;
        $member->save();

        Session::flash('success', 'Added successfully!'); 
        return redirect()->route('dashboard.members', [$s_id, $g_id]);
    }

    public function editMember($s_id, $g_id, $id)
    {
        // $group = Group::find($id);
        // return view('dashboard.groups.edit')->withMember($group);
    }    

    public function updateMember(Request $request, $s_id, $g_id, $id)
    {
        $group = Group::find($id);
        $this->validate($request, [
          'name'               => 'required',
          'formation'          => 'required',
          'meeting_day'        => 'required',
          'village'            => 'required',
          'min_savings_dep'    => 'required',
          'min_security_dep'   => 'required',
          'status'             => 'required',
          'user_id'            => 'required',
        ]);
        
        $group->name = $request->name;
        $group->formation = strtotime($request->formation);
        $group->meeting_day = $request->meeting_day;
        $group->village = $request->village;
        $group->min_savings_dep = $request->min_savings_dep;
        $group->min_security_dep = $request->min_security_dep;
        $group->status = $request->status;
        $group->status = $request->status;
        $group->user_id = $request->user_id;
        $group->save();

        Session::flash('success', 'Updated successfully!'); 
        return redirect()->route('dashboard.members');
    }

    public function getSingleMember($s_id, $g_id, $m_id)
    {
    	$staff = User::find($s_id);
    	$group = Group::find($g_id);
        $member = Member::find($m_id);
        return view('dashboard.groups.members.singlemember')
        				->withStaff($staff)
        				->withGroup($group)
        				->withMember($member);
    }
}
