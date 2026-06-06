<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class UserController extends Controller
{
    // Show the upload form for contacts
    public function uploadForm()
    {
        return view('frontend.pages.users.upload');
    }

    // Show the contacts list
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.pages.users.list', compact('contacts'));
    }
public function upload(Request $request)
{
    $request->validate([
        'file' => 'nullable|file|max:10240',
        'emails' => 'nullable|string',
    ]);

    $added = 0;
    $emailsToProcess = [];

    // 1. Fayldan oxuma (Yalnız CSV və ya TXT faylları üçün)
    if ($request->hasFile('file')) {
        $path = $request->file('file')->getRealPath();
        $content = file_get_contents($path);
        
        // UTF-8 BOM təmizləmə (Excel-in gizli simvolları)
        $content = str_replace("\xEF\xBB\xBF", '', $content);
        $lines = explode("\n", str_replace("\r", "", $content));
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // Vergül və ya nöqtəli vergül ayırıcısını yoxla
            $delimiter = str_contains($line, ';') ? ';' : ',';
            $columns = explode($delimiter, $line);
            $email = trim($columns[0]);

            // Əgər sətirdə sadəcə "email" sözü yazılıbsa (başlıqdırsa), onu keç
            if (strtolower($email) === 'email') continue;

            $emailsToProcess[] = $email;
        }
    }

    // 2. Textarea-dan oxuma (Excel-dən kopyalayıb yapışdırdıqların)
    if ($request->filled('emails')) {
        $textLines = explode("\n", str_replace("\r", "", $request->emails));
        foreach ($textLines as $line) {
            $email = trim($line);
            if (!empty($email) && strtolower($email) !== 'email') {
                $emailsToProcess[] = $email;
            }
        }
    }

    // 3. Bazaya yazma (Dublikatları silərək)
    foreach (array_unique($emailsToProcess) as $email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Contact::updateOrCreate(
                ['email' => $email],
                ['name' => null, 'phone' => null]
            );
            $added++;
        }
    }

    if ($added == 0) {
        return back()->withErrors(['error' => 'Heç bir düzgün email tapılmadı. Əgər fayl yükləyirsinizsə, mütləq CSV formatında olduğundan əmin olun.']);
    }

    return back()->with('success', "Uğurla tamamlandı. $added email bazaya yazıldı.");
}

// Tek bir kontaktı silmək üçün
public function delete($id)
{
    $contact = Contact::findOrFail($id);
    $contact->delete();

    return back()->with('success', 'Kontakt uğurla silindi.');
}

// Seçilmiş kontaktları silmək üçün
public function deleteAll()
{
    // Bütün datanı silmək
    Contact::query()->delete();

    return back()->with('success', 'Bütün kontaktlar uğurla silindi.');
}

}
