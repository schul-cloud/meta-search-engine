<?php
#error_log("Content-Length: >".$_SERVER['CONTENT_LENGTH'].'<');

header('Content-Type: application/vnd.api+json');

$JSONAPI = array(
  'version' => '1.0',
  'meta' => array(
    'name' => 'schul-cloud-meta-search-engine',
    'source' => 'https://github.com/schul-cloud/meta-search-engine',
    'description' => 'This is a meta search engine which unites other search engines.'
  )
);

if (isset($_SERVER['Accept'])) {
  $accepted_content_types = explode('.', $string);
  $served_content_types = array('*/*', 'application/*', 'application/vnd.api+json');
  $content_type_is_acceptable = false;
  foreach ($accepted_content_types as $accepted_content_type) {
    if (in_array($accepted_content_type, $served_content_types)) {
      $content_type_is_acceptable = true;
      break;
    }
  }
} else {
  $content_type_is_acceptable = false;
}

if (!$content_type_is_acceptable) {
  # we can not serve this content type
  $response = array(
    'jsonapi' => $JSONAPI,
    'errors' => array(
      array(
        'status' => '406',
        'title' => 'Not Acceptable',
        'detail' => '"application/vnd.api+json" is the content type to accept.'
      )
    )
  );
  http_response_code(406);
  echo json_encode($response);
} else {
  # This is a proper response
  $response = array(
    'jsonapi' => $JSONAPI,
    'links' => array(
      'self' => array(
        'href' => 'http://'.$_SERVER['HOST'].'/v1/search/',
        'meta' => array(
          'count' => 0,
          'limit' => 10,
          'offset' => 0,
        )
      ),
      'first' => null,
      'last' => null,
      'prev' => null,
      'next' => null
    ),
    'data' => array(),
  );
  echo json_encode($response);
}

flush();
?>