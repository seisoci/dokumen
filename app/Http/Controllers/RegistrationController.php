<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Dependent;
use App\Models\Education;
use App\Models\EmergencyContact;
use App\Models\Family;
use App\Models\ForeignLanguage;
use App\Models\Formation;
use App\Models\Organization;
use App\Models\Others;
use App\Models\Training;
use App\Models\WorkExperience;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try {
        $decrypted = Crypt::decrypt($id);
        Formation::where('id', $decrypted)->select('description')->first();
      } catch (DecryptException $e ) {
        abort(404, $e);
      } catch (ModelNotFoundException $e){
        abort(404, $e);

      }
      return view('frontend.registration');
    }

    public function store(Request $request, $id)
    {

      DB::transaction(function() use($request, $id)
      {

        $formation_id = Crypt::decrypt($id);
        $applicant_id = Applicant::create([
          'formation_id'  => $formation_id,
          'full_name'     => $request->input('applicant.full_name'),
          'nickname'      => $request->input('applicant.nickname'),
          'birthplace'    => $request->input('applicant.birthplace'),
          'birthdate'     => $request->input('applicant.birthdate'),
          'email'         => $request->input('applicant.email'),
          'gender'        => $request->input('applicant.gender'),
          'religion'      => $request->input('applicant.religion'),
          'status'        => $request->input('applicant.status'),
          'height'        => $request->input('applicant.height'),
          'no_identity'   => $request->input('applicant.no_identity'),
          'address_ktp'   => $request->input('applicant.address_ktp'),
          'npwp'          => $request->input('applicant.npwp'),
          'address'       => $request->input('applicant.address'),
          'phone'         => $request->input('applicant.phone'),
          'phone_2'       => $request->input('applicant.phone_2')
        ]);

        Dependent::create([
          'applicant_id'    => $applicant_id->id,
          'full_name'       => $request->input('dependents.full_name'),
          'gender'          => $request->input('dependents.gender'),
          'relationship'    => $request->input('dependents.relationship'),
          'last_education'  => $request->input('dependents.last_education'),
        ]);

        foreach ($request->families['full_name'] as $key => $val) {
          Family::create([
            'applicant_id'  => $applicant_id->id,
            'full_name'     => $request->input('families.full_name.'.$key),
            'gender'        => $request->input('families.gender.'.$key),
            'relationship'  => $request->input('families.relationship.'.$key),
            'last_education'=> $request->input('families.last_education.'.$key),
            'birthplace'    => $request->input('families.birthplace.'.$key),
            'birthdate'     => $request->input('families.birthdate.'.$key)
          ]);
        }

        EmergencyContact::create([
          'applicant_id'    => $applicant_id->id,
          'full_name'       => $request->input('emergency_contacts.full_name'),
          'relationship'    => $request->input('emergency_contacts.relationship'),
          'phone'           => $request->input('emergency_contacts.phone'),
          'address'         => $request->input('emergency_contacts.address'),
        ]);

        Education::create([
          'applicant_id'      => $applicant_id->id,
          'institution_name'  => $request->input('education.institution_name'),
          'city'              => $request->input('education.city'),
          'majors'            => $request->input('education.majors'),
          'graduation_year'   => $request->input('education.graduation_year'),
          'gpa'               => $request->input('education.gpa'),
          'continue_education'=> $request->input('education.continue_education'),
        ]);

        Organization::create([
          'applicant_id'  => $applicant_id->id,
          'name'          => $request->input('organizations.name'),
          'position'      => $request->input('organizations.position'),
          'year'          => $request->input('organizations.year'),
        ]);

        Training::create([
          'applicant_id'  => $applicant_id->id,
          'name'          => $request->input('trainings.name'),
          'year'          => $request->input('trainings.year'),
          'expired'       => $request->input('trainings.expired'),
        ]);

        ForeignLanguage::create([
          'applicant_id'  => $applicant_id->id,
          'language'      => 'english',
          'listening'     => $request->input('foreign_languages.listening'),
          'speaking'      => $request->input('foreign_languages.speaking'),
          'writing'       => $request->input('foreign_languages.writing'),
        ]);

        foreach ($request->work_experiences['name'] as $key => $val) {
          WorkExperience::create([
            'applicant_id'  => $applicant_id->id,
            'name'          => $request->input('work_experiences.name.'.$key),
            'sector'        => $request->input('work_experiences.sector.'.$key),
            'address'       => $request->input('work_experiences.address.'.$key),
            'position'      => $request->input('work_experiences.position.'.$key),
            'date_start'    => $request->input('work_experiences.date_start.'.$key),
            'date_end'      => $request->input('work_experiences.date_end.'.$key),
            'salary'        => $request->input('work_experiences.salary.'.$key),
            'resign'        => $request->input('work_experiences.resign.'.$key)
          ]);
        }

        $fileName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $fileName);

        Others::create([
          'applicant_id' => $applicant_id->id,
          'answer_1'     => $request->input('others.answer_1'),
          'answer_2'     => $request->input('others.answer_2'),
          'answer_3'     => $request->input('others.answer_3'),
          'answer_4'     => $request->input('others.answer_4'),
          'answer_5'     => $request->input('others.answer_5'),
          'answer_6'     => $request->input('others.answer_6'),
          'answer_7'     => $request->input('others.answer_7'),
          'answer_8'     => $request->input('others.answer_8'),
          'answer_9'     => $request->input('others.answer_9'),
          'answer_10'    => $fileName,
        ]);


      });

      return response()->json($request->others);
    }
}
