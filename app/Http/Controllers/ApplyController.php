<?php

namespace App\Http\Controllers;

use PDOException;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Applicant;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendNewApplicationEmailJob;

class ApplyController extends Controller
{
    public function create()
    {
        return Inertia::render('Apply/Create', [

        ]);
    }


    public function storePersonalInfo(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'marital_status' => 'required|string|in:Single,Married,Divorced,Widowed',
            'postal_address' => 'required|string',
            'country' => 'required|string',
            'contact' => 'required|string',
            'current_work' => 'required|string',
            'settlement' => 'required|string',
            'email_address' => 'required|email',
            'residence' => 'required|string',
            'next_of_kin' => 'required|string',
            'next_of_kin_contact' => 'required|string',
            'profession' => 'required|string',
            'name_of_father' => 'required|string',
            'profession_of_father' => 'required|string',
            'name_of_mother' => 'required|string',
            'profession_of_mother' => 'required|string',
            'name_of_guardian' => 'required|string',
            'profession_of_guardian' => 'required|string',
            'is_parent_or_guardian_owning_house' => 'required|string|in:Yes,No',
            'is_parent_or_guardian_renting_house' => 'required|string|in:Yes,No',
            'is_parent_or_guardian_business_owner' => 'required|string|in:Yes,No',
            'is_parent_or_guardian_car_owner' => 'required|string|in:Yes,No',
            'name_of_travel_sponsor' => 'required|string',
            'name_of_benefactor' => 'required|string',
            'educational_certificate' => 'required|mimes:pdf|max:5120'
        ]);

        if ($request->hasFile('educational_certificate') && $request->file('educational_certificate')->isValid()) {
            $file = $request->file('educational_certificate');
            $filePath = $file->store('uploads');

            session(['educational_certificate' => $filePath]);
        }

        $validated['date_of_birth'] = Carbon::parse($validated['date_of_birth'])->format('Y-m-d');
        $validated = Arr::except($validated, ['educational_certificate']);
        session(['personal_info' => $validated]);

        return back();
    }

    public function storeChurchInfo(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'is_born_again' => 'required|string',
            'is_called' => 'required|string',
            'explain_calling' => 'required_if:use_narcotics_currently,Yes|string',
            'church' => 'required|string',
            'role_in_church' => 'required|string',
            'duration_of_service' => 'required|numeric|min:0|max:20',
            'history_before_born_again' => 'required|string',
            'history_of_present_church' => 'required|string',
            'history_of_roles_in_church' => 'required|string',
            'reason_for_coming_to_bible_school' => 'required|string',
        ]);

        session(['church_info' => $validated]);

        return back();
    }

    public function storeHealthInfo(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'is_having_medical_condition' => 'required|string',
            'medical_condition' => 'nullable|string',
            'is_on_regular_medication' => 'required|string',
            'medications' => 'nullable|string',
            'has_had_major_surgeries' => 'required|string',
            'surgeries' => 'nullable|string',
            'is_having_allergies' => 'required|string',
            'allergies' => 'nullable|string',
            'diseases_treated' => 'nullable|string',
        ]);

        // Set default 'none' for nullable fields if they're null or empty
        $fieldsToDefault = [
            'medical_condition',
            'medications',
            'surgeries',
            'allergies',
            'diseases_treated'
        ];

        foreach ($fieldsToDefault as $field) {
            if (empty($validated[$field])) {
                $validated[$field] = 'none';
            }
        }

        session(['health_info' => $validated]);

        return back();
    }

    public function storeCriminalInfo(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'is_having_criminal_record' => 'required|string',
            'criminal_records' => 'nullable|string',
        ]);

        // Set default 'none' for criminal_records if it's null or empty
        if (empty($validated['criminal_records'])) {
            $validated['criminal_records'] = 'none';
        }

        session(['criminal_info' => $validated]);

        return back();
    }


    public function storeRecommendationInfo(Request $request): \Illuminate\Http\RedirectResponse
    {
        $rules = [
            'recommended_by' => 'required|string',
            'recommendation_file' => 'required|mimes:pdf|max:10000', // PDF files, maximum size 10MB (10000 KB)
        ];

        // Only require recommendation_by_other if recommended_by is "Others"
        if ($request->recommended_by === 'Others') {
            $rules['recommendation_by_other'] = 'required|string';
        } else {
            $rules['recommendation_by_other'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        // Set default value for recommendation_by_other if not provided and not "Others"
        if ($request->recommended_by !== 'Others' && empty($validated['recommendation_by_other'])) {
            $validated['recommendation_by_other'] = 'none';
        }

        $validated = Arr::except($validated, 'recommendation_file');
        session(['recommendation_info' => $validated]);

        if ($request->hasFile('recommendation_file') && $request->file('recommendation_file')->isValid()) {
            $file = $request->file('recommendation_file');
            $filePath = $file->store('uploads');

            session(['recommendation_file' => $filePath]);
        }

        return back();
    }

    public function storeSocialHistory(Request $request): \Illuminate\Http\RedirectResponse
    {
        $baseRules = [
            'use_narcotics_currently' => 'required|string|in:Yes,No',
            'use_narcotics_in_past' => 'required|string|in:Yes,No',
            'have_been_arrested_before' => 'required|string|in:Yes,No',
            'have_been_prosecuted_before' => 'required|string|in:Yes,No',
            'have_been_jailed_before' => 'required|string|in:Yes,No',
            'is_taking_alcohol' => 'required|string|in:Yes,No',
            'use_alcohol_in_past' => 'required|string|in:Yes,No',
            'have_been_involved_in_robbery' => 'required|string|in:Yes,No',
            'have_been_a_rebel' => 'required|string|in:Yes,No',
            'have_been_in_prostitution' => 'required|string|in:Yes,No',
            'vices' => 'nullable|array',
            'is_virgin' => 'required|string|in:Yes,No',
        ];

        // Add conditional validation rules
        $historyFields = [
            'current_narcotics_history' => 'use_narcotics_currently',
            'past_narcotics_history' => 'use_narcotics_in_past',
            'arrest_history' => 'have_been_arrested_before',
            'prosecution_history' => 'have_been_prosecuted_before',
            'jail_history' => 'have_been_jailed_before',
            'alcohol_history' => 'is_taking_alcohol',
            'past_alcohol_history' => 'use_alcohol_in_past',
            'past_robbery_history' => 'have_been_involved_in_robbery',
            'past_rebelious_history' => 'have_been_a_rebel',
            'past_prostitution_history' => 'have_been_in_prostitution',
        ];

        foreach ($historyFields as $historyField => $conditionField) {
            $baseRules[$historyField] = 'nullable|string';
        }

        $validated = $request->validate($baseRules);

        // Set default values for history fields when answer is "No"
        foreach ($historyFields as $historyField => $conditionField) {
            if ($validated[$conditionField] === 'No' || empty($validated[$historyField])) {
                $validated[$historyField] = 'none';
            }
        }

        // Convert vices array to comma-separated string
        if (isset($validated['vices']) && is_array($validated['vices'])) {
            $validated['vices'] = collect($validated['vices'])->implode(',');
        } else {
            $validated['vices'] = '';
        }

        session(['social_info' => $validated]);

        return back();
    }

    public function confirmation(Request $request)
    {

        $personalInfo = session('personal_info');
        $churchInfo = session('church_info');
        $healthInfo = session('health_info');
        $criminalInfo = session('criminal_info');
        $recommendationInfo = session('recommendation_info');
        $socialInfo = session('social_info');
        $recommendationFile = session('recommendation_file');
        $educationalCertificate = session('educational_certificate');

        $data = collect(array_merge($personalInfo, $churchInfo, $healthInfo, $criminalInfo, $recommendationInfo, $socialInfo));
        $pdf = Pdf::loadView('pdf.application', array('data' =>  $data));
        $content = $pdf->download()->getOriginalContent();
        $applicationPdf = Storage::put('uploads/'.  $personalInfo['email_address']. '.pdf', $content) ;

        $files = [
            storage_path('app/' .$recommendationFile),
            storage_path('app/' .$educationalCertificate),
            storage_path('app/' . 'uploads/' . $personalInfo['email_address']. '.pdf'),
        ];

        $details = [
            'title' => 'New Application Submitted',
            'body' => 'hello',
            'email' => 'ebenagbekeye@gmail.com',
            'files' => $files
        ];

        dispatch(new SendNewApplicationEmailJob($details));


        try {

            DB::beginTransaction();

            $applicant = Applicant::create($personalInfo);
            $applicant->ChurchInfo()->create($churchInfo);
            $applicant->healthInfo()->create($healthInfo);
            $applicant->criminalInfo()->create($criminalInfo);
            $applicant->recommendationInfo()->create($recommendationInfo);
            $applicant->socialInfo()->create($socialInfo);

            DB::commit();
            session()->forget('personal_info');
            session()->forget('church_info');
            session()->forget('health_info');
            session()->forget('criminal_info');
            session()->forget('recommendation_info');
            session()->forget('social_info');



            return to_route('apply.complete');
        } catch (PDOException $e) {


            return back()->withErrors(['error' => 'A Database error occured', 'message' => $e->getMessage()]);

        } catch (QueryException $e) {


            return back()->withErrors(['error' => 'A Database error occured', 'message' => $e->getMessage()]);
        } catch (\Exception $e) {




            return back()->withErrors($e->getMessage());
        }











    }



}
