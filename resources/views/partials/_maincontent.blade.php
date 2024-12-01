<main>
    <!-- Content header -->
    <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
        <h1 class="text-2xl font-semibold">Dashboard</h1>
        <div class="flex items-center" x-data="{ isOn: false }">
            <p style="padding-right: 10px">Change date range</p>
            <button
                class="relative focus:outline-none"
                x-cloak
                @click="
                                            isOn = !isOn;
                                            if (isOn) {
                                                ohDearTotalTimeLastWeek();
                                                ohDearUptimeLastMonth();
                                                postmarkSentCountMonth();
                                            } else {
                                                ohDearTotalTimeLastHour();
                                                ohDearUptimeLastWeek();
                                                postmarkSentCountWeek();
                                            }
                                        "
            >
                <div
                    class="w-12 h-6 transition rounded-full outline-none bg-primary-100 dark:bg-primary-darker"
                ></div>
                <div
                    class="absolute top-0 left-0 inline-flex items-center justify-center w-6 h-6 transition-all duration-200 ease-in-out transform scale-110 rounded-full shadow-sm"
                    :class="{ 'translate-x-0  bg-white dark:bg-primary-100': !isOn, 'translate-x-6 bg-primary-light dark:bg-primary': isOn }"
                ></div>
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="mt-2">
        <!-- State cards -->
        <!-- Charts -->
        <div class="grid grid-cols-1 p-4 space-y-8 lg:gap-8 lg:space-y-0 lg:grid-cols-2">
            <!-- Line chart card ohDear total time -->
            <div class="col-span-2 bg-white rounded-md dark:bg-darker" x-data="{ isOn: false }">
                <!-- Card header -->
                <div class="flex items-center justify-between p-4 border-b dark:border-primary">
                    <h4 class="text-lg font-semibold text-gray-500 dark:text-light">Total time in
                        milliseconds <p1 id="totalTimeMs">(Last Hour)</p1>
                    </h4>
                </div>
                <!-- Chart -->
                <div class="relative p-4 h-72">
                    <canvas data-dateAdd="{{json_encode($data['ohDearTotalTimeData']['dateAdd'])}}"
                            data-totalTime="{{json_encode($data['ohDearTotalTimeData']['totalTimeArray'])}}"
                            data-slug="{{$slug}}" id="lineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Two grid columns -->
        <div class="grid grid-cols-1 p-4 space-y-8 lg:gap-8 lg:space-y-0 lg:grid-cols-3">
            <!-- Outbound overview bar chart -->
            <div class="col-span-2 bg-white rounded-md dark:bg-darker">
                <!-- Card header -->
                <div class="p-4 border-b dark:border-primary">
                    <h4 class="text-lg font-semibold text-gray-500 dark:text-light">Outbound overview <p1 id="outbound">(Last week)</p1></h4>
                </div>
                <p class="p-4">
                                <span class="text-2xl font-medium text-gray-500 dark:text-light"
                                      id="usersCount"></span>
                    <span class="text-sm font-medium text-gray-500 dark:text-primary"></span>
                </p>
                <!-- Chart -->
                <div style="height: 260px" class="relative p-4">
                    <canvas data-date="{{json_encode($data['postmarkSentCount']['date'])}}"
                            data-sent="{{json_encode($data['postmarkSentCount']['sent'])}}"
                            data-SMTPApiError="{{json_encode($data['postmarkBounces']['SmtpApiError'])}}"
                            data-HardBounce="{{json_encode($data['postmarkBounces']['HardBounce'])}}"
                            data-slug="{{$slug}}" id="barChartSentCount"></canvas>
                </div>
            </div>
            <!-- Line chart card ohDear uptime -->
            <div class="col-span-1 bg-white rounded-md dark:bg-darker" x-data="{ isOn: false }">
                <!-- Card header -->
                <div class="flex items-center justify-between p-4 border-b dark:border-primary">
                    <h4 class="text-lg font-semibold text-gray-500 dark:text-light">Average uptime <p1 id="upTime">(Last week)</p1></h4>
                    <div class="flex items-center">
                    </div>
                </div>
                <!-- Chart -->
                <div class="relative p-4 h-72">
                    <canvas data-dateTime="{{json_encode($data['ohDearAverageUptimeData']['dateTime'])}}"
                            data-upTime="{{json_encode($data['ohDearAverageUptimeData']['upTime'])}}"
                            data-slug="{{$slug}}" id="lineChartUpTime"
                            style="width: 867px; height: 256px"></canvas>
                </div>
            </div>
        </div>
    </div>
</main>
