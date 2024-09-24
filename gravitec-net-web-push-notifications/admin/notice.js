jQuery(document).ready(notice);

var state = {
    post_id : ajax_object.post_id,  // post id sent from php backend
    first_modified : undefined,     // when the post was first modified
    started : false,                // post notification requests started
    interval: undefined,            // global interval for reattempting requests
    interval_count : 0,             // how many times has the request been attempted
    status : undefined              // whether the post is scheduled or published
  }
    
function notice() {
  if (!isWpCoreEditorDefined()) {
    return;
  }


  const editor = wp.data.select("core/editor");
  const get_wp_attr = attr => {
    return editor.getEditedPostAttribute(attr);
  };
	
  wp.data.subscribe(() => {

    const post = editor.getCurrentPost();

    if(!post || post === {}){
      return;
    }

    if (!state.first_modified) {
      state.first_modified = post.modified;	
    }

    const { modified, status } = post;
    state.status = status;

    const post_modified = modified !== state.first_modified;

    const is_published = status === "publish";

    if (!state.started && post_modified && is_published ) {
      state.interval = setInterval(get_metadata, 3000);
      state.started = true;
    }
  });

  const get_metadata = () => {
    const data = {
      action: "show_notice",
      post_id: state.post_id
    };

    jQuery.get(ajax_object.ajax_url, data, function(response) {
      response = JSON.parse(response);

	  const recipients = response.recipients;
	  const status_code = response.status_code;
	  const response_body = response.response_body;
		
      const is_status_empty = status_code.length == 0;
      const is_recipients_empty = recipients.length == 0;

      if(!is_status_empty && !is_recipients_empty){
        if (status_code === "0") {
          error_notice("Gravitec.net - Web Push Notifications: request failed with status code 0. "+response_body);
          reset_state();
          return;
        }
		  
        if (status_code >= 400) {
          if (!response_body) {
            error_notice(
              "Gravitec.net - Web Push Notifications: there was a " +
                status_code +
                " error sending your notification"
            );
          } else {
            error_notice("Gravitec.net - Web Push Notifications: there was a " + status_code + " error sending your notification: " + response_body);
          }

          reset_state();
          return;
        }

        if (recipients === "0") {
          error_notice(
            "Gravitec.net - Web Push Notifications: there were no recipients."
          );
          reset_state();

        } else if (recipients) {
          show_notice(recipients);
          reset_state();
        }
      }
    });
  };

  const show_notice = recipients => {
    const plural = recipients == 1 ? "" : "s";
    var delivery_link_text = "";

    if (state.status === "publish") {
      var notice_text = "Gravitec.net - Web Push Notifications: Successfully sent a notification to ";
    }

    wp.data
      .dispatch("core/notices")
      .createNotice(
        "info",
        notice_text + recipients + " recipient" + plural,
        {
            id:'gravitecnet-notice',
            isDismissible: true
        }
      );
  };

  const error_notice = error => {
    wp.data.dispatch("core/notices").createNotice("error", error, {
        isDismissible: true,
        id:'gravitecnet-error'
    });
  };

  const reset_state = () => {
    clearInterval(state.interval);
    state.interval = undefined;
    state.interval_count = 0;
    state.started = false;
    state.first_modified = undefined;
  }
};

const isWpCoreEditorDefined = () => {
  var unloadable = "";
  if (!wp || !wp.data || !wp.data.select("core/editor")) {
    if (!wp) {
      unloadable = "wp";
    } else if (!wp.data) {
      unloadable = "wp.data";
    } else if (!wp.data.select("core/editor")) {
      unloadable = 'wp.data.select("core/editor")';
    }
    return false;
  } else {
    return true;
  }
};