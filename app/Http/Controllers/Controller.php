<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Parameter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function logActivity(string $action, string $description): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            $currentTime = Carbon::now();
            $logData = [
                'sid' => $user->sch_id ?? null,
                'uid' => $user->uid ?? null,
                'lvl' => $user->syslevel ?? null,
                'ip' => \Illuminate\Support\Facades\Request::ip(),
                'app' => 'mais',
                'act' => $action,
                'des' => $description,
                'dt' => $currentTime->toDateString(),
                'tm' => $currentTime->format('H:i:s'),
            ];

            DB::table('sys_log')->insert($logData);
        }
    }

    protected function getCommon()
    {
        return [

            'types' => Parameter::where('grp', 'clientcate1')
                ->pluck('prm', 'code')
                ->toArray(),
            'categories' => Parameter::where('grp', 'type_CLIENT')
                ->pluck('prm', 'code')
                ->toArray(),
            'districts' => Parameter::where('grp', 'district')
                ->pluck('prm', 'code')
                ->toArray(),
            'subdistricts' => Parameter::where('grp', 'subdistrict')
                ->pluck('prm', 'code')
                ->toArray(),
            'cities' => Parameter::where('grp', 'city')
                ->orderBy('prm')
                ->pluck('prm', 'code')
                ->toArray(),
            'user_positions' => Parameter::where('grp', 'user_position')
                ->pluck('prm', 'code')
                ->toArray(),
            'user_statuses' => Parameter::where('grp', 'clientstatus')
                ->pluck('prm', 'val')
                ->toArray(),
            'statements' => Parameter::where('grp', 'statement')
                ->pluck('prm', 'code')
                ->toArray(),
            'audit_types' => Parameter::where('grp', 'audit_type')
                ->pluck('prm', 'code')
                ->toArray(),
            'financial_statement_statuses' => Parameter::where('grp', 'splkstatus')
                ->whereNotIn('val', [0, 1, 4])
                ->pluck('prm', 'val')
                ->toArray(),
            'admin_departments' => Parameter::where('grp', 'jobdiv')
                ->pluck('prm', 'code')
                ->toArray(),
            'admin_positions' => Parameter::where('grp', 'job')
                ->pluck('prm', 'code')
                ->toArray(),
            'admin_groups' => Parameter::where('grp', 'syslevel')
                ->pluck('prm', 'code')
                ->toArray(),
            'statuses' => Parameter::where('grp', 'clientstatus')
                ->pluck('prm', 'val')
                ->toArray(),
            'states' => Parameter::where('grp', 'state')
                ->pluck('prm', 'code')
                ->toArray(),

            'countries' => Parameter::where('grp', 'country')
                ->pluck('prm', 'code')
                ->toArray(),
            'financial_statement_statuses_report' => Parameter::where('grp', 'splkstatus')
                ->whereNotIn('val', [0, 4])
                ->pluck('prm', 'val')
                ->toArray(),

        ];
    }

    protected function fetchParameterOptions(Request $request, array $mappings): array
    {
        // Fetch parameters only when the request key is filled and map the result in one step
        return array_reduce(array_keys($mappings), function ($results, $key) use ($request, $mappings) {
            if ($request->filled($key)) {
                [$group, $resultKey] = $mappings[$key];
                $results[$resultKey] = Parameter::where('grp', $group)
                    ->where('etc', $request->$key)
                    ->pluck('prm', 'code')
                    ->toArray();
            }
            return $results;
        }, []);
    }

    protected function sendEmail(array $to, array $dynamicTemplateData, string $templateType): void
    {
        try {
            $apiUrl = env('AWFATECH_EMAIL_API_URL', 'https://api01.awfatech.com/api/v2/email/general/send');
            $apiKey = env('AWFATECH_EMAIL_API_KEY');

            if (!$apiKey) {
                Log::channel('external_error')->error('Awfatech API key not configured in .env file');
                return;
            }

            $payload = [
                'username' => 'infomail2umy',
                'from' => [
                    'email' => 'do_not_reply@mail2u.my',
                    'name' => 'Awfatech eboos'
                ],
                'reply_to' => [
                    [
                        'email' => 'awfatech@mail2u.my',
                        'name' => 'awfatech'
                    ]
                ],
                'personalizations' => [
                    [
                        'to' => $to,
                        'dynamic_template_data' => $dynamicTemplateData
                    ]
                ],
                'template_type' => $templateType
            ];

            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
                'Content-Type' => 'application/json'
            ])->post($apiUrl, $payload);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['success']) && $responseData['success'] === true) {
                    // Email sent successfully - no action needed
                    return;
                } else {
                    Log::channel('external_error')->error('Awfatech API returned unsuccessful response', [
                        'response' => $responseData,
                        'payload' => $payload
                    ]);
                }
            } else {
                Log::channel('external_error')->error('Awfatech API request failed', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'payload' => $payload
                ]);
            }

        } catch (\Exception $e) {
            Log::channel('external_error')->error('Exception occurred while sending email', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $payload ?? null
            ]);
        }
    }



}
