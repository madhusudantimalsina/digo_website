<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormSubmission;

class FormController extends Controller
{
    /**
     * CONTACT PAGE – /contact (nav link)
     */
    public function contact()
    {
        return view('public.contact');
    }

    /**
     * Handle contact form submit (Full Name, Email, Message)
     */
    public function submitContact(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'message'   => 'required|string|max:2000',
        ]);

        // Ensure a row exists in forms table for "contact"
        $form = Form::firstOrCreate(
            ['slug' => 'contact'],
            [
                'name'        => 'Contact Form',
                'description' => 'Contact page form',
                'is_active'   => true,
            ]
        );

FormSubmission::create([
    'form_id'   => $form->id,
    'full_name' => $data['full_name'],
    'email'     => $data['email'],
    'message'   => $data['message'],
    'status'    => 'new',
]);


        return redirect()
            ->route('contact')
            ->with('success', 'Thank you for contacting us. We will get back to you soon.');
    }

    /**
     * GENERIC FORMS – /forms/{slug}
     * (Membership, loan request, etc. if you use them later)
     */
    public function show($slug)
    {
        $form = Form::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Simple generic form view – you can customize later
        return view('public.forms.show', compact('form'));
    }

    /**
     * Handle generic form submit for /forms/{slug}
     * Currently uses same fields as contact (full_name, email, message)
     */
    public function submit(Request $request, $slug)
    {
        $form = Form::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'message'   => 'required|string|max:2000',
        ]);

        FormSubmission::create([
            'form_id'   => $form->id,
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'message'   => $data['message'],
            'status'    => 'new',
        ]);

        return back()->with('success', 'Your form has been submitted successfully.');
    }
}
