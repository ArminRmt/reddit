<?php

namespace App\Observers;

use App\Models\PostVote;

class PostVoteObserver
{

    // Handle the PostVote "created" event.

    public function created(PostVote $postVote)
    {
        $postVote->post()->increment('votes', $postVote->vote);
    }
}
