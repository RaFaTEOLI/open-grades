<?php

namespace App\Repositories\InvitationLink;

interface InvitationLinkRepositoryInterface {
    public function all();
    public function findById($invitationId);
    public function findByUserId($userId);
    public function update($invitationId, $set);
    public function delete($invitationId);
    public function register($request);
    public function generateHash();
}
