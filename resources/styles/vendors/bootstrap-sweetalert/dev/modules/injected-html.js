var injectedHTML = 

  // Dark overlay
  `<div class="sweet-overlay" tabIndex="-1"></div>` +

  // Modal
  `<div class="sweet-alert" tabIndex="-1">` +

    // Error icon
    `<div class="sa-icon sa-error">
      <span class="sa-x-mark">
        <span class="sa-line sa-left"></span>
        <span class="sa-line sa-right"></span>
      </span>
    </div>` +

    // Warning icon
    `<div class="sa-icon sa-warning">
      <span class="sa-body"></span>
      <span class="sa-dot"></span>
    </div>` +

    // Info icon
    `<div class="sa-icon sa-info"></div>` +

    // Success icon
    `<div class="sa-icon sa-success">
      <span class="sa-line sa-tip"></span>
      <span class="sa-line sa-long"></span>

      <div class="sa-placeholder"></div>
      <div class="sa-fix"></div>
    </div>` +

    `<div class="sa-icon sa-custom"></div>` +

    // Title, text and input
    `<h2>Title</h2>
    <p class="lead text-muted">Text</p>
    <div class="form-group">
      <input type="text" class="form-control" tabIndex="3" />
      <span class="sa-input-error help-block">
        <span class="glyphicon glyphicon-exclamation-sign"></span> <span class="sa-help-text">Not valid</span>
      </span>
    </div>` +

    // Cancel and confirm buttons
    `<div class="sa-button-container">
      <button class="cancel btn btn-lg" tabIndex="2">Cancel</button>
      <div class="sa-confirm-button-container">
        <button class="confirm btn btn-lg" tabIndex="1">OK</button>` + 

      // Loading animation
        `<div class="la-ball-fall">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
    </div>` +

  // End of modal
  `</div>`;

export default injectedHTML;
