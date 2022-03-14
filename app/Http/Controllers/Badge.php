<?php

namespace App\Http\Controllers;

use App\Models\AchievedBadge;
use App\Models\Badge as ModelsBadge;
use App\Models\Chapter;
use App\Models\Language;
use App\Models\Matter;
use App\Models\Planner;
use App\Models\Result;
use App\Models\Study;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Badge extends Controller
{
    public static function mrPerfect($matterId, $type) {
        $badge = null;
        $study = Study::where('matter_id', $matterId)->where('user_id', auth()->user()->id)->first();
        $matter = Matter::whereId($matterId)->first();
        $chapter = Chapter::whereId($matter->chapter->id)->first();
        $language = Language::whereId($chapter->language->id)->first();
        $badgeId = ModelsBadge::where('type', '2')
                            ->where('grade', $type)
                            ->first()->id;

        switch ($type) {
            case '1':
                if ($study->point==$matter->difficulty->point) {
                    $badge = AchievedBadge::where('user_id', auth()->user()->id)
                                        ->where('badge_id', $badgeId)->first();

                    if (empty($badge)) {
                        AchievedBadge::insert([
                            'user_id' => auth()->user()->id,
                            'badge_id' => $badgeId,
                        ]);

                        Badge::medalist();
                        return AchievedBadge::where('user_id', auth()->user()->id)
                                            ->where('badge_id', $badgeId)->first();
                    } else {
                        return null;
                    }
                }
                break;

            case '2':
                $chapterPoint = 0;
                $userChapterPoint = 0;
                foreach ($chapter->matters()->get() as $matters) {
                    $chapterPoint += $matters->difficulty->point;
                    $studies = Study::where('matter_id', $matters->id)
                                    ->where('user_id', auth()->user()->id)
                                    ->where('finished', '1')
                                    ->first();
                    $userChapterPoint += !empty($studies) ? $studies->point : 0;
                }

                if ($chapterPoint==$userChapterPoint) {
                    $badge = AchievedBadge::where('user_id', auth()->user()->id)
                                        ->where('badge_id', $badgeId)->first();

                    if (empty($badge)) {
                        AchievedBadge::insert([
                            'user_id' => auth()->user()->id,
                            'badge_id' => $badgeId,
                        ]);

                        Badge::medalist();
                        return AchievedBadge::where('user_id', auth()->user()->id)
                                            ->where('badge_id', $badgeId)->first();
                    } else {
                        return null;
                    }
                }
                break;

            case '3':
                $languagePoint = 0;
                $userLanguagePoint = 0;
                foreach ($language->chapters()->get() as $chapters) {
                    foreach ($chapters->matters()->get() as $matters) {
                        $languagePoint += $matters->difficulty->point;
                        $studies = Study::where('matter_id', $matters->id)
                                        ->where('user_id', auth()->user()->id)
                                        ->where('finished', '1')
                                        ->first();
                        $userLanguagePoint += !empty($studies) ? $studies->point : 0;
                    }
                }

                if ($languagePoint==$userLanguagePoint) {
                    $badge = AchievedBadge::where('user_id', auth()->user()->id)
                                        ->where('badge_id', $badgeId)->first();

                    if (empty($badge)) {
                        AchievedBadge::insert([
                            'user_id' => auth()->user()->id,
                            'badge_id' => $badgeId,
                        ]);

                        Badge::medalist();
                        return AchievedBadge::where('user_id', auth()->user()->id)
                                            ->where('badge_id', $badgeId)->first();
                    } else {
                        return null;
                    }
                }
                break;
        }
    }

    public static function debugger($matterId) {
        $badge = null;
        $study = Study::where('matter_id', $matterId)->where('user_id', auth()->user()->id)->first();
        $matter = Matter::whereId($matterId)->first();
        $timeDifference = strtotime(date('Y-m-d G:i:s'))-strtotime($study->created_at);

        if ($timeDifference<=420) {
            $badgeId = ModelsBadge::where('type', '3')
                                ->where('grade', '3')
                                ->first()->id;
        } elseif ($timeDifference<=600) {
            $badgeId = ModelsBadge::where('type', '3')
                                ->where('grade', '2')
                                ->first()->id;
        } elseif ($timeDifference<=900) {
            $badgeId = ModelsBadge::where('type', '3')
                                ->where('grade', '1')
                                ->first()->id;
        } else {
            $badgeId = 9999;
        }

        $badge = AchievedBadge::where('user_id', auth()->user()->id)
                                ->where('badge_id', $badgeId)->first();
        if (empty($badge) && $badgeId!=9999) {
            AchievedBadge::insert([
                'user_id' => auth()->user()->id,
                'badge_id' => $badgeId,
            ]);

            Badge::medalist();
            return AchievedBadge::where('user_id', auth()->user()->id)
                                ->where('badge_id', $badgeId)->first();
        } else {
            return null;
        }
    }

    public static function hardWorker($matterId) {
        $badge = null;
        $study = Study::where('matter_id', $matterId)->where('user_id', auth()->user()->id)->first();
        $matter = Matter::whereId($matterId)->first();
        $timeDifference = strtotime(date('Y-m-d G:i:s'))-strtotime($study->created_at);

        if ($timeDifference<=300) {
            $badgeId = ModelsBadge::where('type', '4')
                                ->where('grade', '3')
                                ->first()->id;
        } elseif ($timeDifference<=420) {
            $badgeId = ModelsBadge::where('type', '4')
                                ->where('grade', '2')
                                ->first()->id;
        } elseif ($timeDifference<=600) {
            $badgeId = ModelsBadge::where('type', '4')
                                ->where('grade', '1')
                                ->first()->id;
        } else {
            $badgeId = 9999;
        }

        $badge = AchievedBadge::where('user_id', auth()->user()->id)
                                ->where('badge_id', $badgeId)->first();
        if (empty($badge) && $badgeId!=9999) {
            AchievedBadge::insert([
                'user_id' => auth()->user()->id,
                'badge_id' => $badgeId,
            ]);

            Badge::medalist();
            return AchievedBadge::where('user_id', auth()->user()->id)
                                ->where('badge_id', $badgeId)->first();
        } else {
            return null;
        }
    }

    public static function gamer() {
        $result = Result::where('user_id', auth()->user()->id)
                        ->where('date', date('Y-m-d'))->first();
        if ($result->point>=10000) {
            $badgeId = ModelsBadge::where('type', '5')
                                ->where('grade', '3')
                                ->first()->id;
        } elseif ($result->point>=5000) {
            $badgeId = ModelsBadge::where('type', '5')
                                ->where('grade', '2')
                                ->first()->id;
        } elseif ($result->point>=2000) {
            $badgeId = ModelsBadge::where('type', '5')
                                ->where('grade', '1')
                                ->first()->id;
        } else {
            $badgeId = 9999;
        }

        $badge = AchievedBadge::where('user_id', auth()->user()->id)
                                ->where('badge_id', $badgeId)->first();
        if (empty($badge) && $badgeId!=9999) {
            AchievedBadge::insert([
                'user_id' => auth()->user()->id,
                'badge_id' => $badgeId,
            ]);

            Badge::medalist();
            return AchievedBadge::where('user_id', auth()->user()->id)
                                ->where('badge_id', $badgeId)->first();
        } else {
            return null;
        }
    }

    public static function studious() {
        $planner = Planner::where('user_id', auth()->user()->id)->first();
        $count = 0;
        if ($planner->monday=='3') $count++;
        if ($planner->tuesday=='3') $count++;
        if ($planner->wednesday=='3') $count++;
        if ($planner->thursday=='3') $count++;
        if ($planner->friday=='3') $count++;
        if ($planner->saturday=='3') $count++;
        if ($planner->sunday=='3') $count++;

        if ($count==7) {
            $badgeId = ModelsBadge::where('type', '6')
                                ->where('grade', '3')
                                ->first()->id;
        } elseif ($count==6) {
            $badgeId = ModelsBadge::where('type', '6')
                                ->where('grade', '2')
                                ->first()->id;
        } elseif ($count==5) {
            $badgeId = ModelsBadge::where('type', '6')
                                ->where('grade', '1')
                                ->first()->id;
        } else {
            $badgeId = 9999;
        }

        $badge = AchievedBadge::where('user_id', auth()->user()->id)
                                ->where('badge_id', $badgeId)->first();
        if (empty($badge) && $badgeId!=9999) {
            AchievedBadge::insert([
                'user_id' => auth()->user()->id,
                'badge_id' => $badgeId,
            ]);

            Badge::medalist();
            return AchievedBadge::where('user_id', auth()->user()->id)
                                ->where('badge_id', $badgeId)->first();
        } else {
            return null;
        }
    }

    public static function master() {
        $badgeId = ModelsBadge::where('type', '99')
                                ->where('grade', '3')
                                ->first()->id;

        $badge = AchievedBadge::where('user_id', auth()->user()->id)
                                ->where('badge_id', $badgeId)->first();

        if (empty($badge)) {
            AchievedBadge::insert([
                'user_id' => auth()->user()->id,
                'badge_id' => $badgeId,
            ]);

            return AchievedBadge::where('user_id', auth()->user()->id)
                                ->where('badge_id', $badgeId)->first();
        } else {
            return null;
        }
    }

    public static function founder() {
        $users = User::count();
        if ($users<=13) {
            $badgeId = ModelsBadge::where('type', '97')
                                ->where('grade', '3')
                                ->first()->id;

            $badge = AchievedBadge::where('user_id', auth()->user()->id)
                                    ->where('badge_id', $badgeId)->first();

            if (empty($badge)) {
                AchievedBadge::insert([
                    'user_id' => auth()->user()->id,
                    'badge_id' => $badgeId,
                ]);
            }
        }
    }

    protected static function medalist() {
        $badges = DB::table('achieved_badges')
                    ->join('badges', 'achieved_badges.badge_id', '=', 'badges.id')
                    ->where('user_id', auth()->user()->id)
                    ->groupBy('badges.type')
                    ->count();
        if ($badges>=6) {
            $badgeId = ModelsBadge::where('type', '98')
                                ->where('grade', '3')
                                ->first()->id;

            $badge = AchievedBadge::where('user_id', auth()->user()->id)
                                    ->where('badge_id', $badgeId)->first();

            if (empty($badge)) {
                AchievedBadge::insert([
                    'user_id' => auth()->user()->id,
                    'badge_id' => $badgeId,
                ]);
            }
        }
    }
}
