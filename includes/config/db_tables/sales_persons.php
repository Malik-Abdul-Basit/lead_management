<?php


class sales_persons
{
    public $return = [
        "sales_persons" => [
            "gender" => [
                "title" => [
                    'm'=>'Male',
                    'f'=>'Female',
                    'o'=>'Other',
                ],
                "value" => [
                    'male'=>'m',
                    'female'=>'f',
                    'other'=>'o',
                ],
            ],
            "status" => [
                "title" => [
                    0 => 'Pending',
                    1 => 'Activated',
                    2 => 'Deactivated',
                    3 => 'Suspended',
                    4 => 'Suspended by admin',
                    5 => 'Blocked',
                    6 => 'Blocked by admin',
                ],
                "value" => [
                    'pending' => '0',
                    'activated' => '1',
                    'deactivated' => '2',
                    'suspended' => '3',
                    'suspended by admin' => '4',
                    'blocked' => '5',
                    'blocked by admin' => '6',
                ],
                "class" => [
                    0 => 'primary',
                    1 => 'success',
                    2 => 'danger',
                    3 => 'warning',
                    4 => 'warning',
                    5 => 'danger',
                    6 => 'danger',
                    /*7 => 'danger'*/
                ],
                "icon" => [
                    999 => '<div style="margin: -3px 0 0 0;" class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 923.38 1000" style="enable-background:new 0 0 923.38 1000;height:20px; width:34px;" xml:space="preserve">
                            <style type="text/css">.sf0{fill:#FFFFFF;}.so0{opacity:0.8;fill:#3699FF;stroke:#3699FF;stroke-width:5;stroke-miterlimit:10;}.si0{fill:#3699FF;stroke:#3699FF;stroke-width:5;stroke-miterlimit:10;}</style>
                            <path class="sf0" d="M0.36,646.65c0.29-50.08,14.42-95.48,45.62-135.18c8.33-10.6,8.07-12.1-0.36-22.89
	                        C12.68,446.42-2.63,398.69,0.37,345.2c5.4-96.19,75.2-177.53,170.44-197.64c23.88-5.04,48.24-6.2,72.62-2.17
	                        c12.98,2.14,14.5,0.81,20.12-12.39C292.32,65.4,343.78,23.25,413.86,5.85c80.68-20.03,172.23,12.08,221.03,85.29
	                        c9.18,13.77,16.81,28.58,24.94,43.03c5.99,10.66,9.19,12.27,21.24,11.04c40.94-4.18,80.77-0.89,118.42,17.56
	                        c40.73,19.97,72.16,49.75,95.19,88.7c16.3,27.57,24.42,57.58,27.55,89.21c5.35,53.99-10.9,101.59-42.33,144.79
	                        c-1.33,1.83-2.57,3.73-3.94,5.53c-4.75,6.22-4.72,12.18,0.05,18.58c13.41,18.01,24.97,37.08,33.28,58.09
	                        c10.05,25.4,14.85,51.95,14.02,78.91c-1.98,64.46-28.18,117.92-76.82,160.35c-32.04,27.95-69.16,44.8-111.45,48.64
	                        c-17.37,1.58-35.09,0.3-52.58-0.81c-12.39-0.78-17.82,1.2-23.22,12.78c-12.85,27.54-28.14,53.34-50.26,74.68
	                        c-28.95,27.92-63.9,44.13-102.63,52.71c-93.62,20.73-186.15-23.81-232.45-104.61c-4.19-7.31-7.07-15.44-9.89-23.43
	                        c-3.45-9.76-9.23-13.41-19.58-12.08c-65.44,8.43-123.65-7.88-173.01-52.19C30.38,765.82,8.48,718.77,0.48,664.77
	                        c-0.11-0.74-0.12-1.51-0.12-2.26C0.35,657.22,0.36,651.94,0.36,646.65z"/>
	                        <g>
	                            <g>
	                                <g>
	                                    <path class="so0" d="M656.02,619.71c-8.51-6.33-20.54-4.56-26.87,3.95c-3.48,4.68-7.21,9.27-11.07,13.64
				                        c-7.02,7.94-6.28,20.08,1.67,27.1c3.65,3.23,8.19,4.82,12.71,4.82c5.31,0,10.6-2.19,14.39-6.48c4.58-5.18,8.99-10.61,13.11-16.16
				                        C666.3,638.07,664.53,626.04,656.02,619.71z"/>
				                        <path class="so0" d="M688.14,529.65c-10.36-2.26-20.59,4.32-22.85,14.68c-1.24,5.7-2.74,11.41-4.46,16.98
				                        c-3.13,10.13,2.55,20.88,12.68,24.02c1.89,0.58,3.8,0.86,5.68,0.86c8.2,0,15.79-5.29,18.34-13.54c2.04-6.6,3.82-13.38,5.29-20.14
				                        C705.07,542.14,698.5,531.91,688.14,529.65z"/>
				                        <path class="so0" d="M563.6,681.2c-5.1,2.85-10.38,5.51-15.69,7.9c-9.67,4.36-13.96,15.74-9.6,25.4
				                        c3.21,7.1,10.2,11.3,17.51,11.3c2.64,0,5.33-0.55,7.89-1.71c6.3-2.85,12.56-6,18.6-9.37c9.26-5.17,12.58-16.87,7.4-26.13
				                        C584.55,679.35,572.86,676.04,563.6,681.2z"/>
				                        <path class="si0" d="M442.49,346.38v145.66l-70.41,70.41c-7.5,7.5-7.5,19.66,0,27.16c3.75,3.75,8.66,5.62,13.58,5.62
				                        c4.91,0,9.83-1.88,13.58-5.62l76.04-76.04c3.6-3.6,5.62-8.49,5.62-13.58V346.38c0-10.61-8.6-19.2-19.2-19.2
				                        C451.09,327.18,442.49,335.78,442.49,346.38z"/>
				                        <path class="si0" d="M688.28,295.5c-10.61,0-19.2,8.6-19.2,19.2v53.32c-44.69-70.1-122.75-113.81-207.38-113.81
				                        c-65.65,0-127.37,25.57-173.8,71.99C241.47,372.63,215.9,434.35,215.9,500s25.57,127.37,71.99,173.8
				                        c46.42,46.42,108.15,71.99,173.8,71.99c0.16,0,0.32-0.02,0.48-0.02c0.16,0,0.32,0.02,0.48,0.02c6.92,0,13.91-0.29,20.77-0.87
				                        c10.57-0.89,18.42-10.17,17.53-20.74c-0.89-10.57-10.16-18.42-20.74-17.53c-5.8,0.48-11.71,0.73-17.57,0.73
				                        c-0.16,0-0.32,0.02-0.48,0.02c-0.16,0-0.32-0.02-0.48-0.02c-114.35,0-207.38-93.03-207.38-207.38s93.03-207.38,207.38-207.38
				                        c73.7,0,141.48,39.28,178.52,101.77h-52.8c-10.61,0-19.2,8.6-19.2,19.2s8.6,19.2,19.2,19.2h58.62c11.69,0,22.63-3.29,31.95-8.98
				                        c0.6-0.34,1.18-0.71,1.72-1.11c16.71-10.99,27.77-29.91,27.77-51.36V314.7C707.48,304.09,698.88,295.5,688.28,295.5z"/>
				                    </g>
				                </g>
				            </g>
                        </svg>
                        <span class="Tool-Tip-Text Tool-Primary">Pending</span>
                    </div>',
                    0 => '<div style="margin: -3px 0 0 0;" class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 923.38 1000" style="enable-background:new 0 0 923.38 1000;height:20px; width:34px;" xml:space="preserve">
                            <style type="text/css">
	                            .st0_0{fill:#FFFFFF;}
	                            .st1_0{fill:#3699FF;stroke:#3699FF;stroke-width:10;stroke-miterlimit:10;}
	                            .st2_0{fill:none;stroke:#3699FF;stroke-width:45;stroke-miterlimit:10;}
	                        </style>
                            <path class="st0_0" d="M0.36,646.65c0.29-50.08,14.42-95.48,45.62-135.18c8.33-10.6,8.07-12.1-0.36-22.89
	                        C12.68,446.42-2.63,398.69,0.37,345.2c5.4-96.19,75.2-177.53,170.44-197.64c23.88-5.04,48.24-6.2,72.62-2.17
	                        c12.98,2.14,14.5,0.81,20.12-12.39C292.32,65.4,343.78,23.25,413.86,5.85c80.68-20.03,172.23,12.08,221.03,85.29
	                        c9.18,13.77,16.81,28.58,24.94,43.03c5.99,10.66,9.19,12.27,21.24,11.04c40.94-4.18,80.77-0.89,118.42,17.56
	                        c40.73,19.97,72.16,49.75,95.19,88.7c16.3,27.57,24.42,57.58,27.55,89.21c5.35,53.99-10.9,101.59-42.33,144.79
	                        c-1.33,1.83-2.57,3.73-3.94,5.53c-4.75,6.22-4.72,12.18,0.05,18.58c13.41,18.01,24.97,37.08,33.28,58.09
	                        c10.05,25.4,14.85,51.95,14.02,78.91c-1.98,64.46-28.18,117.92-76.82,160.35c-32.04,27.95-69.16,44.8-111.45,48.64
	                        c-17.37,1.58-35.09,0.3-52.58-0.81c-12.39-0.78-17.82,1.2-23.22,12.78c-12.85,27.54-28.14,53.34-50.26,74.68
	                        c-28.95,27.92-63.9,44.13-102.63,52.71c-93.62,20.73-186.15-23.81-232.45-104.61c-4.19-7.31-7.07-15.44-9.89-23.43
	                        c-3.45-9.76-9.23-13.41-19.58-12.08c-65.44,8.43-123.65-7.88-173.01-52.19C30.38,765.82,8.48,718.77,0.48,664.77
	                        c-0.11-0.74-0.12-1.51-0.12-2.26C0.35,657.22,0.36,651.94,0.36,646.65z"/>
                            <path class="st1_0" d="M448.42,361.01v127.11l-61.45,61.45c-6.54,6.54-6.54,17.15,0,23.7c3.27,3.27,7.56,4.91,11.85,4.91
	                        c4.29,0,8.58-1.64,11.85-4.91l66.35-66.35c3.14-3.14,4.91-7.4,4.91-11.85V361.01c0-9.25-7.5-16.76-16.76-16.76
	                        C455.92,344.25,448.42,351.75,448.42,361.01z"/>
                            <circle class="st2_0" cx="459.69" cy="500.27" r="229.43"/>
                        </svg>
                        <span class="Tool-Tip-Text Tool-Primary">Pending</span>
                    </div>',
                    1 => '<div style="margin: -3px 0 0 0;" class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 92.36 100" style="enable-background:new 0 0 92.36 100;height:20px; width:34px;" xml:space="preserve">
                            <style type="text/css">.sf1{fill:#FFFFFF;}.si1{fill:#1BC4BC;}</style>
	                        <g>
	                            <path class="sf1" d="M0,64.89c0.07-5.76,1.65-10.25,4.87-14.12c0.49-0.59,0.44-0.95-0.02-1.52c-3.98-4.9-5.47-10.5-4.59-16.73
	                            C1.58,23.1,9.55,15.44,19.01,14.4c2-0.22,3.97-0.19,5.93,0.15c0.7,0.12,0.91-0.09,1.14-0.7C29.32,5.01,38.95-1.01,48.35,0.14
	                            c8.08,0.99,13.86,5.36,17.41,12.68c0.9,1.85,0.85,1.78,2.9,1.59c7.23-0.68,13.32,1.68,18.18,7.08c2.6,2.89,4.32,6.26,5.07,10.08
	                            c1.21,6.19-0.08,11.84-3.83,16.91c-1.14,1.54-1.17,1.52-0.01,3.05c5.9,7.79,5.71,18.65-0.56,26.23c-5.1,6.17-11.69,8.75-19.64,7.74
	                            c-0.99-0.12-1.43,0.1-1.84,1.07c-3.21,7.63-9.05,12.06-17.16,13.22c-9.12,1.3-18.07-3.72-22.16-11.99
	                            c-0.38-0.77-0.3-1.95-1.11-2.26c-0.7-0.27-1.64,0.12-2.48,0.16C12.61,86.27,4,80.27,0.84,70.14C0.24,68.21-0.04,66.2,0,64.89z"/>
	                            <g>
	                                <rect x="23.36" y="53.26" transform="matrix(0.7071 0.7071 -0.7071 0.7071 51.1113 -7.476)" class="si1" width="22.45" height="9.4"/>
	                                <rect x="29.28" y="45.3" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -20.1947 51.2457)" class="si1" width="44.96" height="9.4"/>
	                            </g>
	                        </g>
	                    </svg>
	                    <span class="Tool-Tip-Text Tool-Success">Activated</span>
                    </div>',
                    2 => '<div style="margin: -3px 0 0 0;" class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 923.38 1000" style="enable-background:new 0 0 923.38 1000;height:20px;width:34px;" xml:space="preserve">
                            <style type="text/css">.sf2{fill:#FFFFFF;}.so2{opacity:0.6;}.si2{fill:#F64E60;}</style>
	                        <g>
	                            <path class="sf2" d="M0.36,646.65c0.29-50.08,14.42-95.48,45.62-135.18c8.33-10.6,8.07-12.1-0.36-22.89
		                        C12.68,446.42-2.63,398.69,0.37,345.2c5.4-96.19,75.2-177.53,170.44-197.64c23.88-5.04,48.24-6.2,72.62-2.17
		                        c12.98,2.14,14.5,0.81,20.12-12.39C292.32,65.4,343.78,23.25,413.86,5.85c80.68-20.03,172.23,12.08,221.03,85.29
		                        c9.18,13.77,16.81,28.58,24.94,43.03c5.99,10.66,9.19,12.27,21.24,11.04c40.94-4.18,80.77-0.89,118.42,17.56
		                        c40.73,19.97,72.16,49.75,95.19,88.7c16.3,27.57,24.42,57.58,27.55,89.21c5.35,53.99-10.9,101.59-42.33,144.79
		                        c-1.33,1.83-2.57,3.73-3.94,5.53c-4.75,6.22-4.72,12.18,0.05,18.58c13.41,18.01,24.97,37.08,33.28,58.09
		                        c10.05,25.4,14.85,51.95,14.02,78.91c-1.98,64.46-28.18,117.92-76.82,160.35c-32.04,27.95-69.16,44.8-111.45,48.64
		                        c-17.37,1.58-35.09,0.3-52.58-0.81c-12.39-0.78-17.82,1.2-23.22,12.78c-12.85,27.54-28.14,53.34-50.26,74.68
		                        c-28.95,27.92-63.9,44.13-102.63,52.71c-93.62,20.73-186.15-23.81-232.45-104.61c-4.19-7.31-7.07-15.44-9.89-23.43
		                        c-3.45-9.76-9.23-13.41-19.58-12.08c-65.44,8.43-123.65-7.88-173.01-52.19C30.38,765.82,8.48,718.77,0.48,664.77
		                        c-0.11-0.74-0.12-1.51-0.12-2.26C0.35,657.22,0.36,651.94,0.36,646.65z"/>
	                            <g class="so2">
	                                <rect x="236.36" y="452.91" transform="matrix(0.7071 0.7071 -0.7071 0.7071 488.7795 -180.0181)" class="si2" width="450.67" height="94.18"/>
	                            </g>
	                            <g>
	                                <path class="si2" d="M461.69,773.65c-150.89,0-273.65-122.76-273.65-273.65S310.8,226.35,461.69,226.35
			                        c150.89,0,273.65,122.76,273.65,273.65S612.58,773.65,461.69,773.65z M461.69,321.02c-98.69,0-178.98,80.29-178.98,178.98
			                        c0,98.69,80.29,178.98,178.98,178.98S640.67,598.69,640.67,500C640.67,401.31,560.38,321.02,461.69,321.02z"/>
	                            </g>
	                        </g>
	                    </svg>
	                    <span class="Tool-Tip-Text Tool-Danger">Deactivated</span>
                    </div>',
                    3 => '<div style="margin: -3px 0 0 0;" class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 92.36 100" style="enable-background:new 0 0 92.36 100; height:20px; width:34px;" xml:space="preserve">
                            <style type="text/css">.sf3{fill:#FFFFFF;}.si3{fill:#FFA800;}</style>
                            <path class="sf3" d="M0,64.89c0.07-5.76,1.65-10.25,4.87-14.12c0.49-0.59,0.44-0.95-0.02-1.52c-3.98-4.9-5.47-10.5-4.59-16.73
	                        C1.58,23.1,9.55,15.44,19.01,14.4c2-0.22,3.97-0.19,5.93,0.15c0.7,0.12,0.91-0.09,1.14-0.7C29.32,5.01,38.95-1.01,48.35,0.14
	                        c8.08,0.99,13.86,5.36,17.41,12.68c0.9,1.85,0.85,1.78,2.9,1.59c7.23-0.68,13.32,1.68,18.18,7.08c2.6,2.89,4.32,6.26,5.07,10.08
	                        c1.21,6.19-0.08,11.84-3.83,16.91c-1.14,1.54-1.17,1.52-0.01,3.05c5.9,7.79,5.71,18.65-0.56,26.23c-5.1,6.17-11.69,8.75-19.64,7.74
	                        c-0.99-0.12-1.43,0.1-1.84,1.07c-3.21,7.63-9.05,12.06-17.16,13.22c-9.12,1.3-18.07-3.72-22.16-11.99c-0.38-0.77-0.3-1.95-1.11-2.26
	                        c-0.7-0.27-1.64,0.12-2.48,0.16C12.61,86.27,4,80.27,0.84,70.14C0.24,68.21-0.04,66.2,0,64.89z"/>
	                        <g>
	                            <path class="si3" d="M39.94,67.08c0-3.31,2.6-5.78,6.24-5.78s6.24,2.47,6.24,5.78c0,3.25-2.6,5.91-6.24,5.91 S39.94,70.33,39.94,67.08z M40.14,27.01h12.08l-2.01,29.69h-8.05L40.14,27.01z"/>
	                        </g>
	                    </svg>
	                    <span class="Tool-Tip-Text Tool-Warning">Suspended</span>
                    </div>',
                    4 => '<div style="margin: -3px 0 0 0;" class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 92.36 100" style="enable-background:new 0 0 92.36 100; height:20px; width:34px;" xml:space="preserve">
                            <style type="text/css">.sf4{fill:#FFFFFF;}.si4{fill:#FFA800;}</style>
                            <path class="sf4" d="M0,64.89c0.07-5.76,1.65-10.25,4.87-14.12c0.49-0.59,0.44-0.95-0.02-1.52c-3.98-4.9-5.47-10.5-4.59-16.73
	                        C1.58,23.1,9.55,15.44,19.01,14.4c2-0.22,3.97-0.19,5.93,0.15c0.7,0.12,0.91-0.09,1.14-0.7C29.32,5.01,38.95-1.01,48.35,0.14
	                        c8.08,0.99,13.86,5.36,17.41,12.68c0.9,1.85,0.85,1.78,2.9,1.59c7.23-0.68,13.32,1.68,18.18,7.08c2.6,2.89,4.32,6.26,5.07,10.08
	                        c1.21,6.19-0.08,11.84-3.83,16.91c-1.14,1.54-1.17,1.52-0.01,3.05c5.9,7.79,5.71,18.65-0.56,26.23c-5.1,6.17-11.69,8.75-19.64,7.74
	                        c-0.99-0.12-1.43,0.1-1.84,1.07c-3.21,7.63-9.05,12.06-17.16,13.22c-9.12,1.3-18.07-3.72-22.16-11.99c-0.38-0.77-0.3-1.95-1.11-2.26
	                        c-0.7-0.27-1.64,0.12-2.48,0.16C12.61,86.27,4,80.27,0.84,70.14C0.24,68.21-0.04,66.2,0,64.89z"/>
	                        <g>
	                            <path class="si4" d="M39.94,67.08c0-3.31,2.6-5.78,6.24-5.78s6.24,2.47,6.24,5.78c0,3.25-2.6,5.91-6.24,5.91 S39.94,70.33,39.94,67.08z M40.14,27.01h12.08l-2.01,29.69h-8.05L40.14,27.01z"/>
	                        </g>
	                    </svg>
	                    <span class="Tool-Tip-Text Tool-Warning">Suspended by admin</span>
                    </div>',
                    5 => '<div style="margin: -3px 0 0 0;" class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 923.38 1000" style="enable-background:new 0 0 923.38 1000;height:20px;width:34px;" xml:space="preserve">
                            <style type="text/css">.sf5{fill:#FFFFFF;}.so5{opacity:0.6;}.si5{fill:#F64E60;}</style>
	                        <g>
	                            <path class="sf5" d="M0.36,646.65c0.29-50.08,14.42-95.48,45.62-135.18c8.33-10.6,8.07-12.1-0.36-22.89
		                        C12.68,446.42-2.63,398.69,0.37,345.2c5.4-96.19,75.2-177.53,170.44-197.64c23.88-5.04,48.24-6.2,72.62-2.17
		                        c12.98,2.14,14.5,0.81,20.12-12.39C292.32,65.4,343.78,23.25,413.86,5.85c80.68-20.03,172.23,12.08,221.03,85.29
		                        c9.18,13.77,16.81,28.58,24.94,43.03c5.99,10.66,9.19,12.27,21.24,11.04c40.94-4.18,80.77-0.89,118.42,17.56
		                        c40.73,19.97,72.16,49.75,95.19,88.7c16.3,27.57,24.42,57.58,27.55,89.21c5.35,53.99-10.9,101.59-42.33,144.79
		                        c-1.33,1.83-2.57,3.73-3.94,5.53c-4.75,6.22-4.72,12.18,0.05,18.58c13.41,18.01,24.97,37.08,33.28,58.09
		                        c10.05,25.4,14.85,51.95,14.02,78.91c-1.98,64.46-28.18,117.92-76.82,160.35c-32.04,27.95-69.16,44.8-111.45,48.64
		                        c-17.37,1.58-35.09,0.3-52.58-0.81c-12.39-0.78-17.82,1.2-23.22,12.78c-12.85,27.54-28.14,53.34-50.26,74.68
		                        c-28.95,27.92-63.9,44.13-102.63,52.71c-93.62,20.73-186.15-23.81-232.45-104.61c-4.19-7.31-7.07-15.44-9.89-23.43
		                        c-3.45-9.76-9.23-13.41-19.58-12.08c-65.44,8.43-123.65-7.88-173.01-52.19C30.38,765.82,8.48,718.77,0.48,664.77
		                        c-0.11-0.74-0.12-1.51-0.12-2.26C0.35,657.22,0.36,651.94,0.36,646.65z"/>
	                            <g class="so5">
	                                <rect x="236.36" y="452.91" transform="matrix(0.7071 0.7071 -0.7071 0.7071 488.7795 -180.0181)" class="si5" width="450.67" height="94.18"/>
	                            </g>
	                            <g>
	                                <path class="si5" d="M461.69,773.65c-150.89,0-273.65-122.76-273.65-273.65S310.8,226.35,461.69,226.35
			                        c150.89,0,273.65,122.76,273.65,273.65S612.58,773.65,461.69,773.65z M461.69,321.02c-98.69,0-178.98,80.29-178.98,178.98
			                        c0,98.69,80.29,178.98,178.98,178.98S640.67,598.69,640.67,500C640.67,401.31,560.38,321.02,461.69,321.02z"/>
	                            </g>
	                        </g>
	                    </svg>
	                    <span class="Tool-Tip-Text Tool-Danger">Blocked</span>
                    </div>',
                    6 => '<div style="margin: -3px 0 0 0;" class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 923.38 1000" style="enable-background:new 0 0 923.38 1000;height:20px;width:34px;" xml:space="preserve">
                            <style type="text/css">.sf6{fill:#FFFFFF;}.so6{opacity:0.6;}.si6{fill:#F64E60;}</style>
	                        <g>
	                            <path class="sf6" d="M0.36,646.65c0.29-50.08,14.42-95.48,45.62-135.18c8.33-10.6,8.07-12.1-0.36-22.89
		                        C12.68,446.42-2.63,398.69,0.37,345.2c5.4-96.19,75.2-177.53,170.44-197.64c23.88-5.04,48.24-6.2,72.62-2.17
		                        c12.98,2.14,14.5,0.81,20.12-12.39C292.32,65.4,343.78,23.25,413.86,5.85c80.68-20.03,172.23,12.08,221.03,85.29
		                        c9.18,13.77,16.81,28.58,24.94,43.03c5.99,10.66,9.19,12.27,21.24,11.04c40.94-4.18,80.77-0.89,118.42,17.56
		                        c40.73,19.97,72.16,49.75,95.19,88.7c16.3,27.57,24.42,57.58,27.55,89.21c5.35,53.99-10.9,101.59-42.33,144.79
		                        c-1.33,1.83-2.57,3.73-3.94,5.53c-4.75,6.22-4.72,12.18,0.05,18.58c13.41,18.01,24.97,37.08,33.28,58.09
		                        c10.05,25.4,14.85,51.95,14.02,78.91c-1.98,64.46-28.18,117.92-76.82,160.35c-32.04,27.95-69.16,44.8-111.45,48.64
		                        c-17.37,1.58-35.09,0.3-52.58-0.81c-12.39-0.78-17.82,1.2-23.22,12.78c-12.85,27.54-28.14,53.34-50.26,74.68
		                        c-28.95,27.92-63.9,44.13-102.63,52.71c-93.62,20.73-186.15-23.81-232.45-104.61c-4.19-7.31-7.07-15.44-9.89-23.43
		                        c-3.45-9.76-9.23-13.41-19.58-12.08c-65.44,8.43-123.65-7.88-173.01-52.19C30.38,765.82,8.48,718.77,0.48,664.77
		                        c-0.11-0.74-0.12-1.51-0.12-2.26C0.35,657.22,0.36,651.94,0.36,646.65z"/>
	                            <g class="so6">
	                                <rect x="236.36" y="452.91" transform="matrix(0.7071 0.7071 -0.7071 0.7071 488.7795 -180.0181)" class="si6" width="450.67" height="94.18"/>
	                            </g>
	                            <g>
	                                <path class="si6" d="M461.69,773.65c-150.89,0-273.65-122.76-273.65-273.65S310.8,226.35,461.69,226.35
			                        c150.89,0,273.65,122.76,273.65,273.65S612.58,773.65,461.69,773.65z M461.69,321.02c-98.69,0-178.98,80.29-178.98,178.98
			                        c0,98.69,80.29,178.98,178.98,178.98S640.67,598.69,640.67,500C640.67,401.31,560.38,321.02,461.69,321.02z"/>
	                            </g>
	                        </g>
	                    </svg>
	                    <span class="Tool-Tip-Text Tool-Danger">Blocked by admin</span>
                    </div>',
                    7 => '<div style="margin: -3px 0 0 0;" class="Tool-Tip">
                        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 923.38 1000" style="enable-background:new 0 0 923.38 1000;height:20px;width:34px;" xml:space="preserve">
                            <style type="text/css">.sf7{fill:#FFFFFF;}.so7{opacity:0.6;}.si7{fill:#F64E60;}</style>
	                        <g>
	                            <path class="sf7" d="M0.36,646.65c0.29-50.08,14.42-95.48,45.62-135.18c8.33-10.6,8.07-12.1-0.36-22.89
		                        C12.68,446.42-2.63,398.69,0.37,345.2c5.4-96.19,75.2-177.53,170.44-197.64c23.88-5.04,48.24-6.2,72.62-2.17
		                        c12.98,2.14,14.5,0.81,20.12-12.39C292.32,65.4,343.78,23.25,413.86,5.85c80.68-20.03,172.23,12.08,221.03,85.29
		                        c9.18,13.77,16.81,28.58,24.94,43.03c5.99,10.66,9.19,12.27,21.24,11.04c40.94-4.18,80.77-0.89,118.42,17.56
		                        c40.73,19.97,72.16,49.75,95.19,88.7c16.3,27.57,24.42,57.58,27.55,89.21c5.35,53.99-10.9,101.59-42.33,144.79
		                        c-1.33,1.83-2.57,3.73-3.94,5.53c-4.75,6.22-4.72,12.18,0.05,18.58c13.41,18.01,24.97,37.08,33.28,58.09
		                        c10.05,25.4,14.85,51.95,14.02,78.91c-1.98,64.46-28.18,117.92-76.82,160.35c-32.04,27.95-69.16,44.8-111.45,48.64
		                        c-17.37,1.58-35.09,0.3-52.58-0.81c-12.39-0.78-17.82,1.2-23.22,12.78c-12.85,27.54-28.14,53.34-50.26,74.68
		                        c-28.95,27.92-63.9,44.13-102.63,52.71c-93.62,20.73-186.15-23.81-232.45-104.61c-4.19-7.31-7.07-15.44-9.89-23.43
		                        c-3.45-9.76-9.23-13.41-19.58-12.08c-65.44,8.43-123.65-7.88-173.01-52.19C30.38,765.82,8.48,718.77,0.48,664.77
		                        c-0.11-0.74-0.12-1.51-0.12-2.26C0.35,657.22,0.36,651.94,0.36,646.65z"/>
	                            <g class="so7">
	                                <rect x="236.36" y="452.91" transform="matrix(0.7071 0.7071 -0.7071 0.7071 488.7795 -180.0181)" class="si7" width="450.67" height="94.18"/>
	                            </g>
	                            <g>
	                                <path class="si7" d="M461.69,773.65c-150.89,0-273.65-122.76-273.65-273.65S310.8,226.35,461.69,226.35
			                        c150.89,0,273.65,122.76,273.65,273.65S612.58,773.65,461.69,773.65z M461.69,321.02c-98.69,0-178.98,80.29-178.98,178.98
			                        c0,98.69,80.29,178.98,178.98,178.98S640.67,598.69,640.67,500C640.67,401.31,560.38,321.02,461.69,321.02z"/>
	                            </g>
	                        </g>
	                    </svg>
	                    <span class="Tool-Tip-Text Tool-Danger">Deleted</span>
                    </div>',
                ],
            ],
        ],
    ];

    /**
     * @return array
     */
    /**
     * @return array
     */
    public function getArray()
    {
        return $this->return;
    }

}

?>