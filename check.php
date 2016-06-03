<?php
function check_condition($name,$condition)
{
  if(isset($condition->touched)) {
    $atime = fileatime($name);
    if($atime < time() - $condition->touched) {
      return false;
    }
  }
  return true;
}

function perform_action($action, $action_data)
{
  switch($action) {
    case "mail":
    case "email":
      $recipient = $action_data->recipient;
      $subject = $action_data->subject;
      $message = $action_data->message;
      mail($recipient, $subject, $message);
      break;
  }
}

function process_rule($rule) {
  $name = $rule->name;
  $conditions = $rule->conditions;
  $ok = true;
  foreach($conditions as $condition) {
    if(!check_condition($name,$condition)) {
      $ok = false;
    }
  }
  if(!$ok) {
    perform_action($rule->action, $rule->action_data);
  }
}

function main()
{
  if(!file_exists('rules.json')) {
    return;
  }

  $rules = json_decode(file_get_contents('rules.json'));
  foreach($rules as $rule) {
    process_rule($rule);
  }
}

main();
?>
