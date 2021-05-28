  <title>Home</title>

      <p id="navBarActive" hidden>projectPage</p>
      <link rel="stylesheet" href="/Style/projectPage.css">

    <div class="d-flex">
      <div id="projectDiv"> 
        <nav id="sidebar">
          <div id="sidebar-header" class="sidebar-header">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="featureToggle" onclick='featureToggle()' checked>
              <label class="custom-control-label" for="featureToggle"><h1>Feature</h1></label>
            </div>
          </div>

          <ul id="activeFeatures" class="list-unstyled components" style="display: none;">
            <?php Render::Features("1"); ?>
          </ul>

          <ul id="inactiveFeatures" class="list-unstyled components" style="display: none;">
            <?php Render::Features("0"); ?>
          </ul>

        </nav>
      </div>
  
      <div id="createProject"></div>

      <div class="content">
        <h1 id="ticketMessage">Tickets</h1>
        <p id="selectedFeatureId" hidden>0</p>
          <div id="ticketDiv">

            <ul class="nav nav-tabs nav-fill" id="projectProgressTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link" id="open-tab" data-toggle="tab" href="#open-content" role="tab" onclick="loadTicketsWithProgress(this.innerHTML)">Open</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="progress-tab" data-toggle="tab" href="#progress-content" role="tab" onclick="loadTicketsWithProgress(this.innerHTML)">In Progress</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="complete-tab" data-toggle="tab" href="#complete-content" role="tab" onclick="loadTicketsWithProgress(this.innerHTML)">Complete</a>
              </li>
            </ul>
            
            <table id="ticketTable" class="table">
              <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-home-tab">
                    <thead>
                      <tr>
                        <th class="col1" scope="col">Ticket ID</th>
                        <th class="col2" scope="col">Summary</th>
                        <th class="col3" scope="col">Progress</th>
                        <th class="col4" scope="col">Assignee</th>
                      </tr>
                    </thead>
            </table>

            <div id="ticketBtnDiv"></div>
          </div>
      </div>
    </div>