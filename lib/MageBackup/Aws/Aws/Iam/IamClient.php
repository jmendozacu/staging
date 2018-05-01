<?php
namespace MageBackup\Aws\Iam;

use MageBackup\Aws\AwsClient;

/**
 * This client is used to interact with the **AWS Identity and Access Management (AWS IAM)** service.
 *
 * @method \MageBackup\Aws\Result addClientIDToOpenIDConnectProvider(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise addClientIDToOpenIDConnectProviderAsync(array $args = [])
 * @method \MageBackup\Aws\Result addRoleToInstanceProfile(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise addRoleToInstanceProfileAsync(array $args = [])
 * @method \MageBackup\Aws\Result addUserToGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise addUserToGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result attachGroupPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise attachGroupPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result attachRolePolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise attachRolePolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result attachUserPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise attachUserPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result changePassword(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise changePasswordAsync(array $args = [])
 * @method \MageBackup\Aws\Result createAccessKey(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createAccessKeyAsync(array $args = [])
 * @method \MageBackup\Aws\Result createAccountAlias(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createAccountAliasAsync(array $args = [])
 * @method \MageBackup\Aws\Result createGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result createInstanceProfile(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createInstanceProfileAsync(array $args = [])
 * @method \MageBackup\Aws\Result createLoginProfile(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createLoginProfileAsync(array $args = [])
 * @method \MageBackup\Aws\Result createOpenIDConnectProvider(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createOpenIDConnectProviderAsync(array $args = [])
 * @method \MageBackup\Aws\Result createPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result createPolicyVersion(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createPolicyVersionAsync(array $args = [])
 * @method \MageBackup\Aws\Result createRole(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createRoleAsync(array $args = [])
 * @method \MageBackup\Aws\Result createSAMLProvider(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createSAMLProviderAsync(array $args = [])
 * @method \MageBackup\Aws\Result createUser(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createUserAsync(array $args = [])
 * @method \MageBackup\Aws\Result createVirtualMFADevice(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createVirtualMFADeviceAsync(array $args = [])
 * @method \MageBackup\Aws\Result deactivateMFADevice(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deactivateMFADeviceAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteAccessKey(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteAccessKeyAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteAccountAlias(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteAccountAliasAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteAccountPasswordPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteAccountPasswordPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteGroupPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteGroupPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteInstanceProfile(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteInstanceProfileAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteLoginProfile(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteLoginProfileAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteOpenIDConnectProvider(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteOpenIDConnectProviderAsync(array $args = [])
 * @method \MageBackup\Aws\Result deletePolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deletePolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result deletePolicyVersion(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deletePolicyVersionAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteRole(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteRoleAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteRolePolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteRolePolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteSAMLProvider(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteSAMLProviderAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteSSHPublicKey(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteSSHPublicKeyAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteServerCertificate(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteServerCertificateAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteSigningCertificate(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteSigningCertificateAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteUser(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteUserAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteUserPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteUserPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteVirtualMFADevice(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteVirtualMFADeviceAsync(array $args = [])
 * @method \MageBackup\Aws\Result detachGroupPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise detachGroupPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result detachRolePolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise detachRolePolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result detachUserPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise detachUserPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result enableMFADevice(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise enableMFADeviceAsync(array $args = [])
 * @method \MageBackup\Aws\Result generateCredentialReport(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise generateCredentialReportAsync(array $args = [])
 * @method \MageBackup\Aws\Result getAccessKeyLastUsed(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getAccessKeyLastUsedAsync(array $args = [])
 * @method \MageBackup\Aws\Result getAccountAuthorizationDetails(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getAccountAuthorizationDetailsAsync(array $args = [])
 * @method \MageBackup\Aws\Result getAccountPasswordPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getAccountPasswordPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result getAccountSummary(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getAccountSummaryAsync(array $args = [])
 * @method \MageBackup\Aws\Result getContextKeysForCustomPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getContextKeysForCustomPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result getContextKeysForPrincipalPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getContextKeysForPrincipalPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result getCredentialReport(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getCredentialReportAsync(array $args = [])
 * @method \MageBackup\Aws\Result getGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result getGroupPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getGroupPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result getInstanceProfile(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getInstanceProfileAsync(array $args = [])
 * @method \MageBackup\Aws\Result getLoginProfile(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getLoginProfileAsync(array $args = [])
 * @method \MageBackup\Aws\Result getOpenIDConnectProvider(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getOpenIDConnectProviderAsync(array $args = [])
 * @method \MageBackup\Aws\Result getPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result getPolicyVersion(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getPolicyVersionAsync(array $args = [])
 * @method \MageBackup\Aws\Result getRole(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getRoleAsync(array $args = [])
 * @method \MageBackup\Aws\Result getRolePolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getRolePolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result getSAMLProvider(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getSAMLProviderAsync(array $args = [])
 * @method \MageBackup\Aws\Result getSSHPublicKey(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getSSHPublicKeyAsync(array $args = [])
 * @method \MageBackup\Aws\Result getServerCertificate(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getServerCertificateAsync(array $args = [])
 * @method \MageBackup\Aws\Result getUser(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getUserAsync(array $args = [])
 * @method \MageBackup\Aws\Result getUserPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise getUserPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result listAccessKeys(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listAccessKeysAsync(array $args = [])
 * @method \MageBackup\Aws\Result listAccountAliases(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listAccountAliasesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listAttachedGroupPolicies(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listAttachedGroupPoliciesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listAttachedRolePolicies(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listAttachedRolePoliciesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listAttachedUserPolicies(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listAttachedUserPoliciesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listEntitiesForPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listEntitiesForPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result listGroupPolicies(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listGroupPoliciesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listGroups(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listGroupsAsync(array $args = [])
 * @method \MageBackup\Aws\Result listGroupsForUser(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listGroupsForUserAsync(array $args = [])
 * @method \MageBackup\Aws\Result listInstanceProfiles(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listInstanceProfilesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listInstanceProfilesForRole(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listInstanceProfilesForRoleAsync(array $args = [])
 * @method \MageBackup\Aws\Result listMFADevices(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listMFADevicesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listOpenIDConnectProviders(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listOpenIDConnectProvidersAsync(array $args = [])
 * @method \MageBackup\Aws\Result listPolicies(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listPoliciesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listPolicyVersions(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listPolicyVersionsAsync(array $args = [])
 * @method \MageBackup\Aws\Result listRolePolicies(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listRolePoliciesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listRoles(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listRolesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listSAMLProviders(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listSAMLProvidersAsync(array $args = [])
 * @method \MageBackup\Aws\Result listSSHPublicKeys(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listSSHPublicKeysAsync(array $args = [])
 * @method \MageBackup\Aws\Result listServerCertificates(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listServerCertificatesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listSigningCertificates(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listSigningCertificatesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listUserPolicies(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listUserPoliciesAsync(array $args = [])
 * @method \MageBackup\Aws\Result listUsers(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listUsersAsync(array $args = [])
 * @method \MageBackup\Aws\Result listVirtualMFADevices(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise listVirtualMFADevicesAsync(array $args = [])
 * @method \MageBackup\Aws\Result putGroupPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise putGroupPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result putRolePolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise putRolePolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result putUserPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise putUserPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result removeClientIDFromOpenIDConnectProvider(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise removeClientIDFromOpenIDConnectProviderAsync(array $args = [])
 * @method \MageBackup\Aws\Result removeRoleFromInstanceProfile(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise removeRoleFromInstanceProfileAsync(array $args = [])
 * @method \MageBackup\Aws\Result removeUserFromGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise removeUserFromGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result resyncMFADevice(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise resyncMFADeviceAsync(array $args = [])
 * @method \MageBackup\Aws\Result setDefaultPolicyVersion(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise setDefaultPolicyVersionAsync(array $args = [])
 * @method \MageBackup\Aws\Result simulateCustomPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise simulateCustomPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result simulatePrincipalPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise simulatePrincipalPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result updateAccessKey(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise updateAccessKeyAsync(array $args = [])
 * @method \MageBackup\Aws\Result updateAccountPasswordPolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise updateAccountPasswordPolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result updateAssumeRolePolicy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise updateAssumeRolePolicyAsync(array $args = [])
 * @method \MageBackup\Aws\Result updateGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise updateGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result updateLoginProfile(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise updateLoginProfileAsync(array $args = [])
 * @method \MageBackup\Aws\Result updateOpenIDConnectProviderThumbprint(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise updateOpenIDConnectProviderThumbprintAsync(array $args = [])
 * @method \MageBackup\Aws\Result updateSAMLProvider(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise updateSAMLProviderAsync(array $args = [])
 * @method \MageBackup\Aws\Result updateSSHPublicKey(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise updateSSHPublicKeyAsync(array $args = [])
 * @method \MageBackup\Aws\Result updateServerCertificate(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise updateServerCertificateAsync(array $args = [])
 * @method \MageBackup\Aws\Result updateSigningCertificate(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise updateSigningCertificateAsync(array $args = [])
 * @method \MageBackup\Aws\Result updateUser(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise updateUserAsync(array $args = [])
 * @method \MageBackup\Aws\Result uploadSSHPublicKey(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise uploadSSHPublicKeyAsync(array $args = [])
 * @method \MageBackup\Aws\Result uploadServerCertificate(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise uploadServerCertificateAsync(array $args = [])
 * @method \MageBackup\Aws\Result uploadSigningCertificate(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise uploadSigningCertificateAsync(array $args = [])
 */
class IamClient extends AwsClient {}