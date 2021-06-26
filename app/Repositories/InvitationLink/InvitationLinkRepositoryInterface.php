<?php

namespace App\Repositories\InvitationLink;

use App\Models\InvitationLink;
use Illuminate\Support\Collection;

interface InvitationLinkRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $invitationId): object;
    public function findByUserId(int $userId): object;
    public function update(int $invitationId, array $set): void;
    public function delete(int $invitationId): bool;
    public function register(array $request): InvitationLink;
    public function getValidatedHash(string $hash): InvitationLink;
    public function generateHash(): string;
}
