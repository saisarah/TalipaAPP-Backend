<?php

namespace Test\Feature;

use App\Models\Farmer;
use App\Models\FarmerGroup;
use App\Models\FarmerGroupMember;
use App\Models\User;
use App\Models\Vendor;
use Tests\TestCase;

class FarmerGroupInvitationTest extends TestCase
{
    const PRESIDENT_ID = 1;

    public function test_must_be_authenticated()
    {
        $this->postJson("/api/farmer-groups/members/invite")
            ->assertStatus(401);
    }

    public function test_user_must_be_a_farmer()
    {
        $user = Vendor::first()->user;

        $this->actingAs($user)
            ->postJson("/api/farmer-groups/members/invite")
            ->assertStatus(403);
    }

    public function test_user_must_belong_to_group()
    {        
        $user = Farmer::factory()->create()->user;

        $this->actingAs($user)
            ->postJson("/api/farmer-groups/members/invite")
            ->assertStatus(403)
            ->assertJson(['message' => "You don't have permission to access this resource."]);
    }

    public function test_user_must_be_the_president_of_the_group()
    {
        $user = Farmer::factory()->create()->user;
        $group = FarmerGroup::first();
        
        FarmerGroupMember::insert([
            'farmer_group_id' => $group->id,
            'farmer_id' => $user->id,
            'role' => FarmerGroupMember::ROLE_MEMBER,
            'membership_status' => FarmerGroupMember::STATUS_APPROVED
        ]);

        $this->actingAs($user)
            ->postJson("/api/farmer-groups/members/invite")
            ->assertStatus(403)
            ->assertJson(['message' => "Only the president can invite members"]);
    }

    public function test_farmer_id_is_required()
    {
        $president = User::find(self::PRESIDENT_ID);
        $this->actingAs($president)
            ->postJson("/api/farmer-groups/members/invite")
            ->assertStatus(422)
            ->assertInvalid(['farmer_id']);
    }

    public function test_farmer_must_not_belong_to_other_group()
    {
        $president = User::find(self::PRESIDENT_ID);
        $farmer = Farmer::factory()->create();

        $other_group = FarmerGroup::where('farmer_id', '!=', $president->id)->first();
        
        FarmerGroupMember::insert([
            'farmer_id' => $farmer->user_id,
            'farmer_group_id' => $other_group->id,
            'role' => FarmerGroupMember::ROLE_MEMBER,
            'membership_status' => FarmerGroupMember::STATUS_APPROVED,
        ]);

        $this->actingAs($president)
            ->postJson("/api/farmer-groups/members/invite", ['farmer_group_id' => $farmer->id])
            ->assertStatus('422')
            ->assertJson(['message' => "This farmer already belongs to a group"]);
    }
}