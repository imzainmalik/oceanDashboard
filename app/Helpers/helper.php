
<?php

use App\Models\Subscription;
use App\Models\TimelineLog;

if (!function_exists('make_log')) {
    function make_log($user_id, $user_name, $action, $desc)
    {
        $create_log = new TimelineLog();
        $create_log->family_owner_id = $user_id;
        $create_log->name = $user_name;
        $create_log->action_name = $action;
        $create_log->action_desc = $desc;
        $create_log->save();
    }
}


if (!function_exists('check_user_subscribed')) {
    function check_user_subscribed()
    {
        $check_customer = Subscription::where('user_id', auth()->user()->id)->first();
        if ($check_customer != null) {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $subscription = $stripe->subscriptions->retrieve($check_customer->stripe_id, []);
        } else {
            $subscription = null;
        }

        return $subscription;
    }
}


if (!function_exists('check_pemission')) {
    function check_pemission($feature_name, $user_role_id)
    {
        $permission = auth()->user()->hasPermission($feature_name);
        // $roleMatch = auth()->user()->role_id == $user_role_id;
        // dd($permission || $user_role_id != 4);

        if (!$permission) {
            if ($user_role_id != 4) {
                return redirect()->back()->with('error', 'You dont have permission to access this feature.');
            }
        }
    }
}

if (!function_exists('colors')) {
    function colors()
    {
        $colors = [
            '#e63946',
            '#f77f00',
            '#2a9d8f',
            '#457b9d',
            '#6d597a',
            '#118ab2',
            '#ef476f',
            '#ff6b6b',
            '#ff9f1c',
            '#06d6a0',
            '#118ab2',
            '#073b4c',
            '#8d99ae',
            '#a4133c',
            '#ff595e',
            '#ffca3a',
            '#8ac926',
            '#1982c4',
            '#6a4c93',
            '#ff006e',
            '#8338ec',
            '#3a86ff',
            '#ffbe0b',
            '#fb5607',
            '#ff006e',
            '#ff7b00',
            '#ff1d58',
            '#00b4d8',
            '#0096c7',
            '#0077b6',
            '#023e8a',
            '#03045e',
            '#bc6ff1',
            '#892cdc',
            '#52057b',
            '#3f37c9',
            '#4361ee',
            '#4895ef',
            '#4cc9f0',
            '#ff0054',
            '#9d4edd',
            '#7b2cbf',
            '#5a189a',
            '#3c096c',
            '#ff70a6',
            '#ff9770',
            '#ffd670',
            '#e9ff70',
            '#06aed5',
            '#086375',
            '#1dd3b0',
            '#affc41',
            '#fffcf2',
            '#e8eddf',
            '#d8e2dc',
            '#ffe5d9',
            '#ffcad4',
            '#f4acb7',
            '#9d8189',
            '#e63946',
            '#e85d04',
            '#dc2f02',
            '#9d0208',
            '#6a040f',
            '#370617',
            '#2ec4b6',
            '#cbf3f0',
            '#90e0ef',
            '#48cae4',
            '#0096c7',
            '#f72585',
            '#b5179e',
            '#7209b7',
            '#560bad',
            '#480ca8',
            '#3a0ca3',
            '#3f37c9',
            '#4361ee',
            '#4895ef',
            '#4cc9f0',
            '#ff9f1c',
            '#ffbf69',
            '#ffffff',
            '#cb997e',
            '#ddbea9',
            '#ffe8d6',
            '#b7b7a4',
            '#a5a58d',
            '#6b705c',
            '#b5838d',
            '#e5989b',
            '#ffb4a2',
            '#ffcdb2',
            '#e9c46a',
            '#f4a261',
            '#e76f51',
            '#264653',
            '#2a9d8f',
            '#8ab17d',
            '#0ead69',
            '#540d6e',
            '#ee4266',
            '#ffd23f',
            '#f3fcf0',
            '#1b9aaa',
            '#06d6a0',
            '#118ab2',
            '#ef476f',
            '#ffc300',
            '#ff5733',
            '#c70039',
            '#900c3f',
            '#581845',
            '#009688',
            '#4caf50',
            '#8bc34a',
            '#cddc39',
            '#ffeb3b',
            '#ffc107',
            '#ff9800',
            '#ff5722',
            '#795548',
            '#9e9e9e',
            '#607d8b'
        ];

        return $colors;
    }
}
