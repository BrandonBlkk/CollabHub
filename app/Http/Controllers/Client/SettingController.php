<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FreelancerCertification;
use App\Models\FreelancerEducation;
use App\Models\FreelancerExperience;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $this->applyPreferredLocale($request->user());

        return view('settings');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'language' => 'sometimes|in:en,my',
            'timezone' => 'sometimes|timezone',
            'currency' => 'sometimes|in:USD,MMK,EUR,GBP,CAD,AUD',
            'dark_mode' => 'sometimes|boolean',
            'email_project_updates' => 'sometimes|boolean',
            'email_new_messages' => 'sometimes|boolean',
            'email_payments' => 'sometimes|boolean',
            'email_marketing' => 'sometimes|boolean',
            'profile_visibility' => 'sometimes|in:public,clients_only,freelancers_only,private',
            'show_online_status' => 'sometimes|boolean',
            'show_earnings' => 'sometimes|boolean',
        ]);

        // Convert string boolean values to actual booleans
        foreach ($validated as $key => $value) {
            if (in_array($key, [
                'dark_mode',
                'email_project_updates',
                'email_new_messages',
                'email_payments',
                'email_marketing',
                'show_online_status',
                'show_earnings'
            ])) {
                $validated[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        }

        $user->settings()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        $this->applyPreferredLocale($user, $validated['language'] ?? null);

        return response()->json([
            'success' => true,
            'message' => __('settings.messages.updated')
        ]);
    }

    public function reset(Request $request)
    {
        $user = $request->user();

        // Create settings
        $user->settings()->update([
            'user_id' => $user->id,
            'language' => 'en',
            'currency' => 'USD',
            'timezone' => 'UTC',
            'dark_mode' => false,
            'email_project_updates' => true,
            'email_new_messages' => true,
            'email_payments' => true,
            'email_marketing' => false,
            'profile_visibility' => 'public',
            'show_online_status' => true,
            'show_earnings' => true,
        ]);

        $this->applyPreferredLocale($user, 'en');

        return response()->json([
            'success' => true,
            'message' => __('settings.messages.reset')
        ]);
    }

    public function getTrashData(Request $request)
    {
        $user = $request->user();

        if (!$user->freelancer) {
            return response()->json([
                'success' => false,
                'message' => 'Freelancer profile not found'
            ], 404);
        }

        $freelancer = $user->freelancer;

        // Fetch deleted items
        $deletedExperiences = $freelancer->experiences()
            ->onlyTrashed()
            ->with(['jobRole'])
            ->orderBy('deleted_at', 'desc')
            ->get()
            ->map(function ($experience) {
                return [
                    'id' => $experience->id,
                    'job_title' => $experience->jobRole->title ?? 'No Job Title',
                    'company' => $experience->company,
                    'start_date' => $experience->start_date,
                    'end_date' => $experience->end_date,
                    'is_current' => $experience->is_current,
                    'deleted_at' => $experience->deleted_at->format('M d, Y'),
                    'deleted_at_raw' => $experience->deleted_at,
                    'formatted_dates' => [
                        'start' => date('M Y', strtotime($experience->start_date)),
                        'end' => $experience->is_current ? 'Present' : ($experience->end_date ? date('M Y', strtotime($experience->end_date)) : 'Present')
                    ]
                ];
            });

        $deletedEducations = $freelancer->educations()
            ->onlyTrashed()
            ->with(['university', 'major'])
            ->orderBy('deleted_at', 'desc')
            ->get()
            ->map(function ($education) {
                return [
                    'id' => $education->id,
                    'degree' => $education->degree,
                    'university' => $education->university->name ?? 'University',
                    'major' => $education->major->name ?? null,
                    'start_year' => $education->start_year,
                    'end_year' => $education->end_year,
                    'is_current' => $education->is_current,
                    'deleted_at' => $education->deleted_at->format('M d, Y'),
                    'deleted_at_raw' => $education->deleted_at,
                    'formatted_years' => [
                        'start' => $education->start_year,
                        'end' => $education->is_current ? 'Present' : ($education->end_year ?? 'Present')
                    ]
                ];
            });

        $deletedCertificates = $freelancer->certificates()
            ->onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get()
            ->map(function ($certificate) {
                return [
                    'id' => $certificate->id,
                    'name' => $certificate->name,
                    'issuer' => $certificate->issuer,
                    'issued_year' => $certificate->issued_year,
                    'expiry_year' => $certificate->expiry_year,
                    'deleted_at' => $certificate->deleted_at->format('M d, Y'),
                    'deleted_at_raw' => $certificate->deleted_at,
                    'formatted_dates' => [
                        'issued' => $certificate->issued_year ?? 'N/A',
                        'expires' => $certificate->expiry_year ?? 'No Expiry'
                    ]
                ];
            });

        // Calculate summary counts
        $summary = [
            'experiences' => $deletedExperiences->count(),
            'educations' => $deletedEducations->count(),
            'certificates' => $deletedCertificates->count(),
            'total' => $deletedExperiences->count() + $deletedEducations->count() + $deletedCertificates->count()
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'summary' => $summary,
                'experiences' => $deletedExperiences,
                'educations' => $deletedEducations,
                'certificates' => $deletedCertificates
            ]
        ]);
    }

    public function restoreItem(Request $request, string $type, int $id)
    {
        try {
            $user = $request->user();

            if (!$user->freelancer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Freelancer profile not found'
                ], 404);
            }

            $freelancerId = $user->freelancer->id;
            $model = $this->getModelByType($type);

            if (!$model) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid item type'
                ], 400);
            }

            // Find the soft-deleted item that belongs to this freelancer
            $item = $model::onlyTrashed()
                ->where('id', $id)
                ->where('freelancer_id', $freelancerId)
                ->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found or you do not have permission'
                ], 404);
            }

            // Restore the item
            $item->restore();

            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' restored successfully',
                'data' => [
                    'id' => $item->id,
                    'type' => $type
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore item: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Permanently delete an item
     */
    public function permanentlyDelete(Request $request, string $type, int $id)
    {
        try {
            $user = $request->user();

            if (!$user->freelancer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Freelancer profile not found'
                ], 404);
            }

            $freelancerId = $user->freelancer->id;
            $model = $this->getModelByType($type);

            if (!$model) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid item type'
                ], 400);
            }

            // Find the soft-deleted item that belongs to this freelancer
            $item = $model::onlyTrashed()
                ->where('id', $id)
                ->where('freelancer_id', $freelancerId)
                ->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found or you do not have permission'
                ], 404);
            }

            // Permanently delete
            $item->forceDelete();

            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' permanently deleted',
                'data' => [
                    'id' => $id,
                    'type' => $type
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete item: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Empty all trash
     */
    public function emptyTrash(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user->freelancer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Freelancer profile not found'
                ], 404);
            }

            $freelancer = $user->freelancer;

            // Get counts before deletion for response
            $counts = [
                'experiences' => $freelancer->experiences()->onlyTrashed()->count(),
                'educations' => $freelancer->educations()->onlyTrashed()->count(),
                'certificates' => $freelancer->certificates()->onlyTrashed()->count()
            ];

            // Permanently delete all trashed items
            $freelancer->experiences()->onlyTrashed()->forceDelete();
            $freelancer->educations()->onlyTrashed()->forceDelete();
            $freelancer->certificates()->onlyTrashed()->forceDelete();

            $totalDeleted = array_sum($counts);

            return response()->json([
                'success' => true,
                'message' => 'All trash emptied successfully',
                'data' => [
                    'deleted_counts' => $counts,
                    'total_deleted' => $totalDeleted
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to empty trash: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get model class by type
     */
    private function getModelByType(string $type): ?string
    {
        return match ($type) {
            'experience' => FreelancerExperience::class,
            'education' => FreelancerEducation::class,
            'certificate' => FreelancerCertification::class,
            default => null
        };
    }

    private function applyPreferredLocale($user, ?string $overrideLanguage = null): void
    {
        $locale = strtolower((string) ($overrideLanguage ?? $user?->settings?->language ?? 'en'));
        app()->setLocale(in_array($locale, ['en', 'my'], true) ? $locale : 'en');
    }
}
