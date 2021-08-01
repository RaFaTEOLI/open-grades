<?php

namespace App\Repositories\InvitationLink;

use App\Repositories\InvitationLink\InvitationLinkRepositoryInterface;
use App\Models\InvitationLink;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;

class InvitationLinkRepository implements InvitationLinkRepositoryInterface
{
    /**
     * Get All Active Invitation Links
     */
    public function all(int $limit = 0, int $offset = 0): Collection
    {
        return InvitationLink::where("used_at", null)
            ->when($limit, function ($query, $limit) {
                return $query->limit($limit);
            })
            ->when($offset && $limit, function ($query, $offset) {
                return $query->offset($offset);
            })
            ->with("user")
            ->get()
            ->map->format();
    }

    /**
     * Get An Invitation Link By Id
     */
    public function findById(int $id): object
    {
        try {
            return InvitationLink::where("id", $id)
                ->firstOrFail()
                ->format();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function findByUserId(int $userId): object
    {
        try {
            return InvitationLink::where("user_id", $userId)
                ->where("used_at", null)
                ->get()
                ->map->format();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update(int $id, array $set): void
    {
        $invitation = InvitationLink::where("id", $id)->first();

        $invitation->update($set);
    }

    public function delete(int $id): bool
    {
        try {
            InvitationLink::findOrFail($id)->delete();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function register(array $request): InvitationLink
    {
        try {
            $invitation = InvitationLink::create($request);
            $invitation->link = InvitationLink::getLinkFromHash($invitation->hash);

            return $invitation;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getValidatedHash(string $hash): InvitationLink
    {
        try {
            $invitation = InvitationLink::where("hash", $hash)
                ->where("used_at", null)
                ->get()
                ->first();
            if (empty($invitation)) {
                throw new Exception(__("validation.invalid_link"));
            }
            return $invitation;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function validateHash(string $hash): bool
    {
        $invitation = InvitationLink::where("hash", $hash)
            ->where("used_at", null)
            ->get()
            ->first();
        if (empty($invitation)) {
            return false;
        }
        return true;
    }
}
