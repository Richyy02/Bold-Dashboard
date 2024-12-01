<?php

namespace App\Models;

use stdClass;

class DefineApi
{
    /** @var string $siteId */
    protected string $siteId = "";
    /** @var string $endPoint */
    protected string $endPoint = "";
    /** @var string $filterStart */
    protected string $filterStart = "";
    /** @var string $filterEnd */
    protected string $filterEnd = "";
    /** @var string $timeStamp */
    protected string $timeStamp = "";
    /** @var string|null $extraFilter */
    protected string|null $extraFilter = null;
    /** @var string|null $extraFilterTimeStamp */
    protected string|null $extraFilterTimeStamp = null;
    /** @var string $filterType */
    protected string $filterType = "";
    /** @var string $value */
    protected string $value = "";
    /** @var string $token */
    protected string $token = "";

    /**
     * @param string $siteId
     * @return string
     */
    private function getSiteId(string $siteId): string
    {
        $this->siteId = $siteId;
        return $siteId;
    }

    /**
     * @param string $endPoint
     * @return string
     */
    private function getEndPoint(string $endPoint): string
    {
        $this->endPoint = $endPoint;
        return $endPoint;
    }

    /**
     * @param string $filterStart
     * @return string
     */
    private function getFilterStart(string $filterStart): string
    {
        $this->filterStart = $filterStart;
        return $filterStart;
    }

    /**
     * @param string $filterEnd
     * @return string
     */
    private function getFilterEnd(string $filterEnd): string
    {
        $this->filterEnd = $filterEnd;
        return $filterEnd;
    }

    /**
     * @param string $timeStamp
     * @return string
     */
    private function getTimeStamp(string $timeStamp): string
    {
        $this->timeStamp = $timeStamp;
        return $timeStamp;
    }

    /**
     * @param string|null $extraFilter
     * @return string|null
     */
    private function getExtraFilter(string|null $extraFilter): string|null
    {
        $this->extraFilter = $extraFilter;
        return $extraFilter;
    }

    /**
     * @param string|null $extraFilterTimeStamp
     * @return string|null
     */
    private function getExtraFilterTimeStamp(string|null $extraFilterTimeStamp): string|null
    {
        $this->extraFilterTimeStamp = $extraFilterTimeStamp;
        return $extraFilterTimeStamp;
    }

    /**
     * @param string $filterType
     * @return string
     */
    private function getFilterType(string $filterType): string
    {
        $this->filterType = $filterType;
        return $filterType;
    }

    /**
     * @param string $value
     * @return string
     */
    private function getValue(string $value): string
    {
        $this->value = $value;
        return $value;
    }

    /**
     * @param string $token
     * @return string
     */
    private function getToken(string $token): string
    {
        $this->token = $token;
        return $token;
    }

    /**
     * @param $siteId
     * @param $endPoint
     * @param $filterStart
     * @param $timeStamp
     * @param $filterEnd
     * @param $extraFilter
     * @param $extraFilterTimeStamp
     * @param $filterType
     * @param $value
     * @param $token
     * @return array|stdClass
     */
    public function OhDearTemplate(
        $siteId,
        $endPoint,
        $filterStart,
        $timeStamp,
        $filterEnd,
        $extraFilter,
        $extraFilterTimeStamp,
        $filterType,
        $value,
        $token
    ): array|stdClass
    {
        $uri = new Uri();
        $uri->setUri('https://ohdear.app/api/sites/' . $this->getSiteId($siteId) . '/' . $this->getEndPoint($endPoint))
            ->addGetValue('filter[' . $this->getFilterStart($filterStart) . ']', date("YmdHis", strtotime($this->getTimeStamp($timeStamp))))
            ->addGetValue('filter[' . $this->getFilterEnd($filterEnd) . ']', date("YmdHis"));
            if ($this->getExtraFilter($extraFilter) && $this->getExtraFilterTimeStamp($extraFilterTimeStamp)){
                $uri->addGetValue('filter[' . $this->getExtraFilter($extraFilter) . ']', $this->getExtraFilterTimeStamp($extraFilterTimeStamp));
            }
            $uri
            ->addGetValue($this->getFilterType($filterType), $this->getValue($value))
            ->setBearerToken($this->getToken($token));
        return $uri->get();
    }

    /**
     * @param $endPoint
     * @param $timeStamp
     * @param $token
     * @return array|stdClass
     */
    public function PostmarkTemplate(
        $endPoint,
        $timeStamp,
        $token
    ): array|stdClass
    {
        $uri = new Uri();
        $uri->setUri('https://api.postmarkapp.com/' . $this->getEndPoint($endPoint))
            ->addHeader('X-Postmark-Server-Token', $token)
            ->addHeader('Accept', "application/json")
            ->addGetValue('fromdate', date("Y-m-d", strtotime($this->getTimeStamp($timeStamp))))
            ->addGetValue('todate', date("Y-m-d"));
        return $uri->get();
    }
}
