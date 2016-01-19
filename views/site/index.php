<?php
/**
 * @var yii\web\View $this
 */
$this->title = Yii::$app->name;
?>
<div class="site-index" style="margin-top: -30px;">
  <div class="row">
  <div class="col-lg-8">
    <div class="panel panel-default">
    <div class="panel-heading">
    <i class="fa fa-bar-chart-o fa-fw"></i> Area Chart Example
    <div class="pull-right">
      <div class="btn-group">
      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
      Actions
      <span class="caret"></span>
      </button>
      <ul class="dropdown-menu pull-right" role="menu">
      <li><a href="#">Action</a>
      </li>
      <li><a href="#">Another action</a>
      </li>
      <li><a href="#">Something else here</a>
      </li>
      <li class="divider"></li>
      <li><a href="#">Separated link</a>
      </li>
      </ul>
      </div>
    </div>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
    <div id="morris-area-chart" style="position: relative;">
      <svg height="357" version="1.1" width="650" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;">
      <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc>
      <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
      <text x="48.5" y="325" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
      <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
      </text>
      <path fill="none" stroke="#aaaaaa" d="M61,325H625" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
      <text x="48.5" y="250" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
      <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">7,500</tspan>
      </text>
      <path fill="none" stroke="#aaaaaa" d="M61,250H625" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
      <text x="48.5" y="175" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
      <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">15,000</tspan>
      </text>
      <path fill="none" stroke="#aaaaaa" d="M61,175H625" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
      <text x="48.5" y="100" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
      <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">22,500</tspan>
      </text>
      <path fill="none" stroke="#aaaaaa" d="M61,100H625" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
      <text x="48.5" y="25" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-style: normal; font-variant: normal; font-weight: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal">
      <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">30,000</tspan>
      </text>
      <path fill="none" stroke="#aaaaaa" d="M61,25H625" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
      <text x="520.8347509113" y="337.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,6)">
      <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2012</tspan>
      </text>
      <text x="270.7010935601458" y="337.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-size: 12px; line-height: normal; font-family: sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,6)">
      <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2011</tspan>
      </text>
      <path fill="#7cb47c" stroke="none" d="M61,271.87C76.76184690157959,266.37,108.28554070473876,254.95625,124.04738760631835,249.87C139.80923450789794,244.78375,171.33292831105712,238.14284153005465,187.0947752126367,231.18C202.68529769137302,224.29284153005466,233.8663426488457,196.52504143646408,249.456865127582,194.47C264.8760631834751,192.43754143646407,295.71445929526124,213.33535714285713,311.1336573511543,214.82999999999998C326.8955042527339,216.3578571428571,358.41919805589305,205.5425,374.18104495747264,206.56C389.9428918590522,207.57750000000001,421.4665856622114,241.031912568306,437.228432563791,222.97C452.8189550425273,205.104412568306,484,71.56500000000003,499.5905224787363,62.85000000000002C515.1810449574726,54.13500000000002,546.3620899149453,140.47146174863389,561.9526123936816,153.25C577.7144592952612,166.16896174863388,609.2381530984204,162.5425,625,165.64L625,325L61,325Z" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></path>
      <path fill="none" stroke="#4da74d" d="M61,271.87C76.76184690157959,266.37,108.28554070473876,254.95625,124.04738760631835,249.87C139.80923450789794,244.78375,171.33292831105712,238.14284153005465,187.0947752126367,231.18C202.68529769137302,224.29284153005466,233.8663426488457,196.52504143646408,249.456865127582,194.47C264.8760631834751,192.43754143646407,295.71445929526124,213.33535714285713,311.1336573511543,214.82999999999998C326.8955042527339,216.3578571428571,358.41919805589305,205.5425,374.18104495747264,206.56C389.9428918590522,207.57750000000001,421.4665856622114,241.031912568306,437.228432563791,222.97C452.8189550425273,205.104412568306,484,71.56500000000003,499.5905224787363,62.85000000000002C515.1810449574726,54.13500000000002,546.3620899149453,140.47146174863389,561.9526123936816,153.25C577.7144592952612,166.16896174863388,609.2381530984204,162.5425,625,165.64" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
      <circle cx="61" cy="271.87" r="5" fill="#4da74d" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="124.04738760631835" cy="249.87" r="2" fill="#4da74d" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="187.0947752126367" cy="231.18" r="2" fill="#4da74d" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="249.456865127582" cy="194.47" r="2" fill="#4da74d" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="311.1336573511543" cy="214.82999999999998" r="2" fill="#4da74d" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="374.18104495747264" cy="206.56" r="2" fill="#4da74d" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="437.228432563791" cy="222.97" r="2" fill="#4da74d" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="499.5905224787363" cy="62.85000000000002" r="2" fill="#4da74d" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="561.9526123936816" cy="153.25" r="2" fill="#4da74d" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="625" cy="165.64" r="2" fill="#4da74d" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <path fill="#a7b3bc" stroke="none" d="M61,298.34C76.76184690157959,292.325,108.28554070473876,279.54875,124.04738760631835,274.28C139.80923450789794,269.01124999999996,171.33292831105712,259.0706557377049,187.0947752126367,256.19C202.68529769137302,253.34065573770494,233.8663426488457,253.6764779005525,249.456865127582,251.36C264.8760631834751,249.0689779005525,295.71445929526124,240.97304945054944,311.1336573511543,237.76C326.8955042527339,234.47554945054944,358.41919805589305,225.23375000000001,374.18104495747264,225.37C389.9428918590522,225.50625,421.4665856622114,252.771912568306,437.228432563791,238.85C452.8189550425273,225.079412568306,484,122.76499999999999,499.5905224787363,114.6C515.1810449574726,106.435,546.3620899149453,164.95834699453553,561.9526123936816,173.53C577.7144592952612,182.19584699453551,609.2381530984204,181.045,625,183.54999999999998L625,325L61,325Z" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></path>
      <path fill="none" stroke="#7a92a3" d="M61,298.34C76.76184690157959,292.325,108.28554070473876,279.54875,124.04738760631835,274.28C139.80923450789794,269.01124999999996,171.33292831105712,259.0706557377049,187.0947752126367,256.19C202.68529769137302,253.34065573770494,233.8663426488457,253.6764779005525,249.456865127582,251.36C264.8760631834751,249.0689779005525,295.71445929526124,240.97304945054944,311.1336573511543,237.76C326.8955042527339,234.47554945054944,358.41919805589305,225.23375000000001,374.18104495747264,225.37C389.9428918590522,225.50625,421.4665856622114,252.771912568306,437.228432563791,238.85C452.8189550425273,225.079412568306,484,122.76499999999999,499.5905224787363,114.6C515.1810449574726,106.435,546.3620899149453,164.95834699453553,561.9526123936816,173.53C577.7144592952612,182.19584699453551,609.2381530984204,181.045,625,183.54999999999998" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
      <circle cx="61" cy="298.34" r="5" fill="#7a92a3" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="124.04738760631835" cy="274.28" r="2" fill="#7a92a3" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="187.0947752126367" cy="256.19" r="2" fill="#7a92a3" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="249.456865127582" cy="251.36" r="2" fill="#7a92a3" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="311.1336573511543" cy="237.76" r="2" fill="#7a92a3" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="374.18104495747264" cy="225.37" r="2" fill="#7a92a3" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="437.228432563791" cy="238.85" r="2" fill="#7a92a3" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="499.5905224787363" cy="114.6" r="2" fill="#7a92a3" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="561.9526123936816" cy="173.53" r="2" fill="#7a92a3" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="625" cy="183.54999999999998" r="2" fill="#7a92a3" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <path fill="#2577b5" stroke="none" d="M61,298.34C76.76184690157959,298.06,108.28554070473876,300.02750000000003,124.04738760631835,297.22C139.80923450789794,294.4125,171.33292831105712,277.12300546448085,187.0947752126367,275.88C202.68529769137302,274.6505054644809,233.8663426488457,289.7156077348066,249.456865127582,287.33C264.8760631834751,284.9706077348066,295.71445929526124,259.25260989010985,311.1336573511543,256.9C326.8955042527339,254.49510989010986,358.41919805589305,265.8125,374.18104495747264,268.3C389.9428918590522,270.7875,421.4665856622114,288.61797814207654,437.228432563791,276.8C452.8189550425273,265.1104781420765,484,181.60375000000002,499.5905224787363,174.27C515.1810449574726,166.93625,546.3620899149453,209.8741120218579,561.9526123936816,218.13C577.7144592952612,226.47661202185793,609.2381530984204,235.04250000000002,625,240.68L625,325L61,325Z" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></path>
      <path fill="none" stroke="#0b62a4" d="M61,298.34C76.76184690157959,298.06,108.28554070473876,300.02750000000003,124.04738760631835,297.22C139.80923450789794,294.4125,171.33292831105712,277.12300546448085,187.0947752126367,275.88C202.68529769137302,274.6505054644809,233.8663426488457,289.7156077348066,249.456865127582,287.33C264.8760631834751,284.9706077348066,295.71445929526124,259.25260989010985,311.1336573511543,256.9C326.8955042527339,254.49510989010986,358.41919805589305,265.8125,374.18104495747264,268.3C389.9428918590522,270.7875,421.4665856622114,288.61797814207654,437.228432563791,276.8C452.8189550425273,265.1104781420765,484,181.60375000000002,499.5905224787363,174.27C515.1810449574726,166.93625,546.3620899149453,209.8741120218579,561.9526123936816,218.13C577.7144592952612,226.47661202185793,609.2381530984204,235.04250000000002,625,240.68" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
      <circle cx="61" cy="298.34" r="5" fill="#0b62a4" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="124.04738760631835" cy="297.22" r="2" fill="#0b62a4" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="187.0947752126367" cy="275.88" r="2" fill="#0b62a4" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="249.456865127582" cy="287.33" r="2" fill="#0b62a4" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="311.1336573511543" cy="256.9" r="2" fill="#0b62a4" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="374.18104495747264" cy="268.3" r="2" fill="#0b62a4" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="437.228432563791" cy="276.8" r="2" fill="#0b62a4" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="499.5905224787363" cy="174.27" r="2" fill="#0b62a4" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="561.9526123936816" cy="218.13" r="2" fill="#0b62a4" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      <circle cx="625" cy="240.68" r="2" fill="#0b62a4" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
      </svg>
      <div class="morris-hover morris-default-style" style="left: 2px; top: 194px; display: none;">
      <div class="morris-hover-row-label">2010 Q1</div>
      <div class="morris-hover-point" style="color: #0b62a4">iPhone: 2,666</div>
      <div class="morris-hover-point" style="color: #7A92A3">iPad: -</div>
      <div class="morris-hover-point" style="color: #4da74d">iPod Touch: 2,647</div>
      </div>
    </div>
    </div>
    <!-- /.panel-body -->
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-clock-o fa-fw"></i> Timeline
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <ul class="timeline">
          <li>
            <div class="timeline-badge"><i class="fa fa-check"></i>
            </div>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Timeline Event</h4>
                <p>
                  <small class="text-muted"><i class="fa fa-time"></i> 11 hours ago via Twitter</small>
                </p>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel justo eu mi scelerisque vulputate. Aliquam in metus eu lectus aliquet egestas.</p>
              </div>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge warning"><i class="fa fa-credit-card"></i>
            </div>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Timeline Event</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel justo eu mi scelerisque vulputate. Aliquam in metus eu lectus aliquet egestas.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel justo eu mi scelerisque vulputate. Aliquam in metus eu lectus aliquet egestas.</p>
              </div>
            </div>
          </li>
          <li>
            <div class="timeline-badge danger"><i class="fa fa-credit-card"></i>
            </div>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Timeline Event</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel justo eu mi scelerisque vulputate. Aliquam in metus eu lectus aliquet egestas.</p>
              </div>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Timeline Event</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel justo eu mi scelerisque vulputate. Aliquam in metus eu lectus aliquet egestas.</p>
              </div>
            </div>
          </li>
          <li>
            <div class="timeline-badge info"><i class="fa fa-save"></i>
            </div>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Timeline Event</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel justo eu mi scelerisque vulputate. Aliquam in metus eu lectus aliquet egestas.</p>
                <hr>
                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-cog"></i> 
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a>
                    </li>
                    <li><a href="#">Another action</a>
                    </li>
                    <li><a href="#">Something else here</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Timeline Event</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel justo eu mi scelerisque vulputate. Aliquam in metus eu lectus aliquet egestas.</p>
              </div>
            </div>
          </li>
          <li class="timeline-inverted">
            <div class="timeline-badge success"><i class="fa fa-thumbs-up"></i>
            </div>
            <div class="timeline-panel">
              <div class="timeline-heading">
                <h4 class="timeline-title">Timeline Event</h4>
              </div>
              <div class="timeline-body">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel justo eu mi scelerisque vulputate. Aliquam in metus eu lectus aliquet egestas.</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <!-- /.panel-body -->
    </div>
  </div>
  <!-- /.col-lg-8 -->
  <div class="col-lg-4">
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-bell fa-fw"></i> Notifications Panel
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
      <div class="list-group">
      <a href="#" class="list-group-item">
        <i class="fa fa-comment fa-fw"></i> New Comment
        <span class="pull-right text-muted small"><em>4 minutes ago</em>
        </span>
      </a>
      <a href="#" class="list-group-item">
        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
        <span class="pull-right text-muted small"><em>12 minutes ago</em>
        </span>
      </a>
      <a href="#" class="list-group-item">
        <i class="fa fa-envelope fa-fw"></i> Message Sent
        <span class="pull-right text-muted small"><em>27 minutes ago</em>
        </span>
      </a>
      <a href="#" class="list-group-item">
        <i class="fa fa-tasks fa-fw"></i> New Task
        <span class="pull-right text-muted small"><em>43 minutes ago</em>
        </span>
      </a>
      <a href="#" class="list-group-item">
        <i class="fa fa-upload fa-fw"></i> Server Rebooted
        <span class="pull-right text-muted small"><em>11:32 AM</em>
        </span>
      </a>
      <a href="#" class="list-group-item">
        <i class="fa fa-bolt fa-fw"></i> Server Crashed!
        <span class="pull-right text-muted small"><em>11:13 AM</em>
        </span>
      </a>
      <a href="#" class="list-group-item">
        <i class="fa fa-warning fa-fw"></i> Server Not Responding
        <span class="pull-right text-muted small"><em>10:57 AM</em>
        </span>
      </a>
      <a href="#" class="list-group-item">
        <i class="fa fa-shopping-cart fa-fw"></i> New Order Placed
        <span class="pull-right text-muted small"><em>9:49 AM</em>
        </span>
      </a>
      <a href="#" class="list-group-item">
        <i class="fa fa-money fa-fw"></i> Payment Received
        <span class="pull-right text-muted small"><em>Yesterday</em>
        </span>
      </a>
      </div>
      <!-- /.list-group -->
      <a href="#" class="btn btn-default btn-block">View All Alerts</a>
    </div>
    <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
    <div class="panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example
    </div>
    <div class="panel-body">
      <div id="morris-donut-chart"><svg height="357" version="1.1" width="294" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#0b62a4" d="M147,272.3333333333333A91.33333333333333,91.33333333333333,0,0,0,233.35180688739518,210.751356692759" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#0b62a4" stroke="#ffffff" d="M147,275.3333333333333A94.33333333333333,94.33333333333333,0,0,0,236.1881801063242,211.72859103668173L271.8004216328777,223.9983111326006A132,132,0,0,1,147,313Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#3980b5" d="M233.35180688739518,210.751356692759A91.33333333333333,91.33333333333333,0,0,0,65.08027060760153,140.61515489624878" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#3980b5" stroke="#ffffff" d="M236.1881801063242,211.72859103668173A94.33333333333333,94.33333333333333,0,0,0,62.38947657646436,139.28864538554163L24.120405911402287,120.42273234437317A137,137,0,0,1,276.52771033109275,225.6270350391385Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#679dc6" d="M65.08027060760153,140.61515489624878A91.33333333333333,91.33333333333333,0,0,0,146.97130678756912,272.3333288262139" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#679dc6" stroke="#ffffff" d="M62.38947657646436,139.28864538554163A94.33333333333333,94.33333333333333,0,0,0,146.97036430978855,275.33332867816983L146.95853097765465,312.999993486061A132,132,0,0,1,28.60506262996425,122.6335815288851Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="147" y="171" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: 800; font-size: 15px; line-height: normal; font-family: Arial;" font-size="15px" font-weight="800" transform="matrix(1.643,0,0,1.643,-94.5171,-115.4137)" stroke-width="0.6086526763990268"><tspan dy="5.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">In-Store Sales</tspan></text><text x="147" y="191" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-style: normal; font-variant: normal; font-weight: normal; font-size: 14px; line-height: normal; font-family: Arial;" font-size="14px" transform="matrix(1.9028,0,0,1.9028,-132.7083,-165.2083)" stroke-width="0.5255474452554745"><tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">30</tspan></text></svg></div>
      <a href="#" class="btn btn-default btn-block">View Details</a>
    </div>
    <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
    <div class="chat-panel panel panel-default">
    <div class="panel-heading">
      <i class="fa fa-comments fa-fw"></i>
      Chat
      <div class="btn-group pull-right">
      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-chevron-down"></i>
      </button>
      <ul class="dropdown-menu slidedown">
        <li>
        <a href="#">
          <i class="fa fa-refresh fa-fw"></i> Refresh
        </a>
        </li>
        <li>
        <a href="#">
          <i class="fa fa-check-circle fa-fw"></i> Available
        </a>
        </li>
        <li>
        <a href="#">
          <i class="fa fa-times fa-fw"></i> Busy
        </a>
        </li>
        <li>
        <a href="#">
          <i class="fa fa-clock-o fa-fw"></i> Away
        </a>
        </li>
        <li class="divider"></li>
        <li>
        <a href="#">
          <i class="fa fa-sign-out fa-fw"></i> Sign Out
        </a>
        </li>
      </ul>
      </div>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
      <ul class="chat">
      <li class="left clearfix">
        <span class="chat-img pull-left">
        <img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar" class="img-circle">
        </span>
        <div class="chat-body clearfix">
        <div class="header">
          <strong class="primary-font">Jack Sparrow</strong> 
          <small class="pull-right text-muted">
          <i class="fa fa-clock-o fa-fw"></i> 12 mins ago
          </small>
        </div>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
        </p>
        </div>
      </li>
      <li class="right clearfix">
        <span class="chat-img pull-right">
        <img src="http://placehold.it/50/FA6F57/fff" alt="User Avatar" class="img-circle">
        </span>
        <div class="chat-body clearfix">
        <div class="header">
          <small class=" text-muted">
          <i class="fa fa-clock-o fa-fw"></i> 13 mins ago</small>
          <strong class="pull-right primary-font">Bhaumik Patel</strong>
        </div>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
        </p>
        </div>
      </li>
      <li class="left clearfix">
        <span class="chat-img pull-left">
        <img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar" class="img-circle">
        </span>
        <div class="chat-body clearfix">
        <div class="header">
          <strong class="primary-font">Jack Sparrow</strong> 
          <small class="pull-right text-muted">
          <i class="fa fa-clock-o fa-fw"></i> 14 mins ago</small>
        </div>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
        </p>
        </div>
      </li>
      <li class="right clearfix">
        <span class="chat-img pull-right">
        <img src="http://placehold.it/50/FA6F57/fff" alt="User Avatar" class="img-circle">
        </span>
        <div class="chat-body clearfix">
        <div class="header">
          <small class=" text-muted">
          <i class="fa fa-clock-o fa-fw"></i> 15 mins ago</small>
          <strong class="pull-right primary-font">Bhaumik Patel</strong>
        </div>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
        </p>
        </div>
      </li>
      </ul>
    </div>
    <!-- /.panel-body -->
    <div class="panel-footer">
      <div class="input-group">
      <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here...">
      <span class="input-group-btn">
        <button class="btn btn-warning btn-sm" id="btn-chat">
        Send
        </button>
      </span>
      </div>
    </div>
    <!-- /.panel-footer -->
    </div>
  <!-- /.panel .chat-panel -->
  </div>
  <!-- /.col-lg-4 -->
  </div>
</div>
