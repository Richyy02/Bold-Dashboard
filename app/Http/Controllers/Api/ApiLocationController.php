<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DefineApi;
use App\Models\ApiLocation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ApiLocationController extends Controller
{
    /**
     * @return array
     */
    private function getOhDearTotalTimeData(ApiLocation $apilocation): array
    {
        $ohDear = new DefineApi();
        $response = $ohDear->OhDearTemplate(
            $apilocation->uri,
            'performance-records',
            'start',
            '-1 hour',
            'end',
            'group_by',
            'minute',
            'sort',
            'day',
            $apilocation->api_key
        );
//        dd($response);
        $data = $response->data;
        $array = array();
        foreach ($data as $datum) {
            $array[date('D H:i', strtotime($datum->created_at))] = $datum->total_time_in_seconds;
        }
        $totalTime = array_values($array);
        $dateAdd = array_keys($array);
        foreach ($totalTime as $value) {
            $totalTimeArray[] = round($value * 1000, 2);
        }
        return compact("data", "totalTimeArray", "dateAdd");
    }

    private function getOhDearTotalTimeDataWeek(ApiLocation $apilocation): array
    {
        $ohDear = new DefineApi();
        $response = $ohDear->OhDearTemplate(
            $apilocation->uri,
            'performance-records',
            'start',
            '-1 week',
            'end',
            'group_by',
            'hour',
            'sort',
            'created_at',
            $apilocation->api_key
        );
        $data = $response->data;
        $array = array();
        foreach ($data as $key => $datum) {
            $array[date('d/m H:i', strtotime($datum->created_at))] = $datum->total_time_in_seconds;
        }

        $totalTime = array_values($array);
        $dateAdd = array_keys($array);
        foreach ($totalTime as $value) {
            $totalTimeArray[] = round($value * 1000, 2);;
        }
        return [
            'totalTime' => $totalTimeArray,
            'dateAdd' => $dateAdd,
        ];
    }

    private function getOhDearUptimeData(ApiLocation $apilocation): array
    {
        $ohDear = new DefineApi();
        $response = $ohDear->OhDearTemplate(
            $apilocation->uri,
            'uptime',
            'started_at',
            '-7 days',
            'ended_at',
            null,
            null,
            'split',
            'day',
            $apilocation->api_key
        );
        $data = $response;
        $array = array();
        foreach ($data as $datum) {
            $array[date('d M D', strtotime($datum->datetime))] = $datum->uptime_percentage;
        }
        $upTime = array_values($array);
        $dateTime = array_keys($array);
        return compact("data", "upTime", "dateTime");
    }

    private function getOhDearUptimeDataMonth(ApiLocation $apilocation): array
    {
        $ohDear = new DefineApi();
        $response = $ohDear->OhDearTemplate(
            $apilocation->uri,
            'uptime',
            'started_at',
            '-1 year',
            'ended_at',
            null,
            null,
            'split',
            'month',
            $apilocation->api_key
        );
        $data = $response;
        $array = array();
        foreach ($data as $datum) {
            $array[date('M Y', strtotime($datum->datetime))] = $datum->uptime_percentage;
        }
        $upTime = array_values($array);
        $dateTime = array_keys($array);
        return [
            'uptime_percentage' => $upTime,
            'dateTime' => $dateTime,
        ];
    }

    private function getPostmarkSentCount(): array
    {
        $postMark = new DefineApi();
        /** @var ApiLocation $apiLocation */
        $apiLocation = ApiLocation::all()->where('slug', 'boldmail')->first();
        $response = $postMark->PostmarkTemplate(
            "stats/outbound/sends",
            "-1 week",
            $apiLocation->api_key
        );
        $data = $response->Days;
        $array = array();
        foreach ($data as $datum) {
            $array[date('d M D', strtotime($datum->Date))] = $datum->Sent;
        }
        $sent = array_values($array);
        $date = array_keys($array);
        return compact("data", "sent", "date");
    }

    private function getPostmarkSentCountMonth(): array
    {
        $postMark = new DefineApi();
        /** @var ApiLocation $apiLocation */
        $apiLocation = ApiLocation::all()->where('slug', 'boldmail')->first();
        $response = $postMark->PostmarkTemplate(
            "stats/outbound/sends",
            "-1 month",
            $apiLocation->api_key
        );
        $data = $response->Days;
        $array = array();
        foreach ($data as $datum) {
            $array[date('d M D', strtotime($datum->Date))] = $datum->Sent;
        }
        $sent = array_values($array);
        $date = array_keys($array);
        return [
            'sent' => $sent,
            'date' => $date
        ];
    }

    private function getPostmarkBounces(): array
    {
        $postMark = new DefineApi();
        /** @var ApiLocation $apiLocation */
        $apiLocation = ApiLocation::all()->where('slug', 'boldmail')->first();
        $response = $postMark->PostmarkTemplate(
            "stats/outbound/bounces",
            "-1 week",
            $apiLocation->api_key
        );
        $data = $response->Days;
        $arrayHardbounce = array();
        $arraySmtpApiError = array();
        foreach ($data as $datum) {
            $hardBounce = 0;
            if (property_exists($datum, 'HardBounce')) {
                $hardBounce = $datum->HardBounce;
            }
            $entry = $hardBounce;
            $arrayHardbounce[date('d M D', strtotime($datum->Date))] = $entry;
        }
        foreach ($data as $datum) {
            $smtpApiError = 0;
            if (property_exists($datum, 'SMTPApiError')) {
                $smtpApiError = $datum->SMTPApiError;
            }
            $entry = $smtpApiError;
            $arraySmtpApiError[date('d M D', strtotime($datum->Date))] = $entry;
        }
        // Get the date array from getPostmarkSentCount()
        $sentCountData = $this->getPostmarkSentCount();
        $sentCountDates = $sentCountData['date'];
        // Filter out dates from $arrayHardbounce that are not in $sentCountDates
        $filteredArrayHardbounce = array_filter($arrayHardbounce, function ($date) use ($sentCountDates) {
            return in_array($date, $sentCountDates);
        }, ARRAY_FILTER_USE_KEY);
        // Filter out dates from $arraySmtpApiError that are not in $sentCountDates
        $filteredArraySmtpApiError = array_filter($arraySmtpApiError, function ($date) use ($sentCountDates) {
            return in_array($date, $sentCountDates);
        }, ARRAY_FILTER_USE_KEY);
        $HardBounce = array_values($filteredArrayHardbounce);
        $SmtpApiError = array_values($filteredArraySmtpApiError);
        $date = array_keys($filteredArrayHardbounce);
        return compact("data", "HardBounce", "SmtpApiError", "date");
    }

    /**
     * @param Request $request
     * @param ApiLocation $apiLocation
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(Request $request, ApiLocation $apiLocation)
    {
        $ohDearTotalTimeData = $this->getOhDearTotalTimeData($apiLocation);
        $ohDearAverageUptimeData = $this->getOhDearUptimeData($apiLocation);
        $postmarkSentCount = $this->getPostmarkSentCount();
        $postmarkBounces = $this->getPostmarkBounces();

        $data['ohDearTotalTimeData'] = $ohDearTotalTimeData;
        $data['ohDearAverageUptimeData'] = $ohDearAverageUptimeData;
        $data['postmarkSentCount'] = $postmarkSentCount;
        $data['postmarkBounces'] = $postmarkBounces;
        $slug = $apiLocation->slug;
//        dd($data);
        return view("index", compact("data", "slug"));
    }

    public function updateOhDearTotalTime(ApiLocation $apiLocation)
    {
        $ohDearData = $this->getOhDearTotalTimeData($apiLocation);

        return response()->json([
            'ohDearData' => $ohDearData
        ]);
    }

    public function updateOhDearTotalTimeWeek(ApiLocation $apiLocation)
    {
        $ohDearData = $this->getOhDearTotalTimeDataWeek($apiLocation);

        return response()->json([
            'getOhDearTotalTimeDataWeek' => $ohDearData
        ]);
    }

    public function updateOhDearUpTimeMonth(ApiLocation $apiLocation)
    {
        $ohDearData = $this->getOhDearUptimeDataMonth($apiLocation);

        return response()->json([
            'getOhDearUpTimeDataMonth' => $ohDearData
        ]);
    }

    public function updateOhDearUpTimeWeek(ApiLocation $apiLocation)
    {
        $ohDearData = $this->getOhDearUptimeData($apiLocation);

        return response()->json([
            'getOhDearUpTimeData' => $ohDearData
        ]);
    }

    public function updatePostmarkSentCountWeek()
    {
        $postmarkData = $this->getPostmarkSentCount();

        return response()->json([
            'getPostmarkSentCount' => $postmarkData
        ]);
    }

    public function updatePostmarkSentCountMonth(){
        $postmarkData = $this->getPostmarkSentCountMonth();

        return response()->json([
            'getPostMarkSentCountMonth' => $postmarkData
        ]);
    }
}
