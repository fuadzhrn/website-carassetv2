{{-- SECTION 3 — OPERATE: Pengelolaan Operasional --}}
<section id="operate" class="ca-operate">
    <div class="ca-container ca-operate__inner">
        <div class="ca-operate__content">
            @if ($data['eyebrow'])
                <span class="ca-operate__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
            @endif

            <h2 class="ca-operate__title ca-section-title">
                {{ $data['title'] }}
            </h2>

            <p class="ca-operate__description ca-body">
                {{ $data['description'] }}
            </p>

            @php
                $operatePointIcons = [0 => 'user-check', 1 => 'map', 2 => 'wrench', 3 => 'file-bar-chart'];
            @endphp
            @if ($data['key_points'])
                <ul class="ca-operate__points ca-list-reset">
                    @foreach ($data['key_points'] as $slot => $point)
                        <li class="ca-operate__point">
                            <span class="ca-operate__point-icon" data-lucide="{{ $operatePointIcons[$slot] ?? 'user-check' }}" aria-hidden="true"></span>
                            <span class="ca-body-sm">{{ $point['text'] }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        @php $blocks = $data['monitoring_panel']['blocks']; @endphp
        <div class="ca-operate__dashboard" data-monitoring-dashboard>
            <div class="ca-operate__dashboard-header">
                @if ($data['monitoring_panel']['panel_title'])
                    <span class="ca-operate__dashboard-title ca-card-title">{{ $data['monitoring_panel']['panel_title'] }}</span>
                @endif
                <span class="ca-operate__dashboard-label ca-label">{{ $data['monitoring_panel']['illustration_label'] }}</span>
            </div>

            <div class="ca-operate__dashboard-grid">
                @if (isset($blocks['unit_status']))
                    <div class="ca-operate__tile ca-operate__tile--wide">
                        <span class="ca-operate__tile-icon" data-lucide="car-front" aria-hidden="true"></span>
                        <div class="ca-operate__tile-body">
                            <span class="ca-operate__tile-label ca-label">{{ $blocks['unit_status']['label'] }}</span>
                            <span class="ca-operate__tile-value ca-body-sm">{{ $blocks['unit_status']['value'] }}</span>
                        </div>
                        @if ($blocks['unit_status']['helper'])
                            <span class="ca-operate__tile-status ca-operate__tile-status--green" data-monitoring-status>
                                {{ $blocks['unit_status']['helper'] }}
                            </span>
                        @endif
                    </div>
                @endif

                @if (isset($blocks['driver_profile']))
                    <div class="ca-operate__tile">
                        <span class="ca-operate__tile-icon" data-lucide="user-check" aria-hidden="true"></span>
                        <div class="ca-operate__tile-body">
                            <span class="ca-operate__tile-label ca-label">{{ $blocks['driver_profile']['label'] }}</span>
                            <span class="ca-operate__tile-value ca-body-sm">{{ $blocks['driver_profile']['value'] }}</span>
                        </div>
                    </div>
                @endif

                @if (isset($blocks['vehicle_activity']))
                    <div class="ca-operate__tile">
                        <span class="ca-operate__tile-icon" data-lucide="map" aria-hidden="true"></span>
                        <div class="ca-operate__tile-body">
                            <span class="ca-operate__tile-label ca-label">{{ $blocks['vehicle_activity']['label'] }}</span>
                            <span class="ca-operate__tile-value ca-body-sm">{{ $blocks['vehicle_activity']['value'] }}</span>
                        </div>
                    </div>
                @endif

                @if (isset($blocks['maintenance_schedule']))
                    <div class="ca-operate__tile">
                        <span class="ca-operate__tile-icon" data-lucide="wrench" aria-hidden="true"></span>
                        <div class="ca-operate__tile-body">
                            <span class="ca-operate__tile-label ca-label">{{ $blocks['maintenance_schedule']['label'] }}</span>
                            <span class="ca-operate__tile-value ca-body-sm">{{ $blocks['maintenance_schedule']['value'] }}</span>
                        </div>
                        @if ($blocks['maintenance_schedule']['helper'])
                            <span class="ca-operate__tile-status ca-operate__tile-status--slate">
                                {{ $blocks['maintenance_schedule']['helper'] }}
                            </span>
                        @endif
                    </div>
                @endif

                @if (isset($blocks['operational_report']))
                    <div class="ca-operate__tile">
                        <span class="ca-operate__tile-icon" data-lucide="file-bar-chart" aria-hidden="true"></span>
                        <div class="ca-operate__tile-body">
                            <span class="ca-operate__tile-label ca-label">{{ $blocks['operational_report']['label'] }}</span>
                            <span class="ca-operate__tile-value ca-body-sm">{{ $blocks['operational_report']['value'] }}</span>
                        </div>
                        @if ($blocks['operational_report']['helper'])
                            <span class="ca-operate__tile-status ca-operate__tile-status--green">
                                {{ $blocks['operational_report']['helper'] }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <p class="ca-operate__dashboard-note ca-disclaimer-text">
                Visual dashboard merupakan ilustrasi untuk menjelaskan konsep monitoring.
                Fitur final mengikuti sistem operasional yang dikonfirmasi perusahaan.
            </p>
        </div>
    </div>
</section>
