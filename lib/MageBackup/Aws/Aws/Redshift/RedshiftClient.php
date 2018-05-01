<?php
namespace MageBackup\Aws\Redshift;

use MageBackup\Aws\AwsClient;

/**
 * This client is used to interact with the **Amazon Redshift** service.
 *
 * @method \MageBackup\Aws\Result authorizeClusterSecurityGroupIngress(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise authorizeClusterSecurityGroupIngressAsync(array $args = [])
 * @method \MageBackup\Aws\Result authorizeSnapshotAccess(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise authorizeSnapshotAccessAsync(array $args = [])
 * @method \MageBackup\Aws\Result copyClusterSnapshot(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise copyClusterSnapshotAsync(array $args = [])
 * @method \MageBackup\Aws\Result createCluster(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createClusterAsync(array $args = [])
 * @method \MageBackup\Aws\Result createClusterParameterGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createClusterParameterGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result createClusterSecurityGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createClusterSecurityGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result createClusterSnapshot(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createClusterSnapshotAsync(array $args = [])
 * @method \MageBackup\Aws\Result createClusterSubnetGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createClusterSubnetGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result createEventSubscription(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createEventSubscriptionAsync(array $args = [])
 * @method \MageBackup\Aws\Result createHsmClientCertificate(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createHsmClientCertificateAsync(array $args = [])
 * @method \MageBackup\Aws\Result createHsmConfiguration(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createHsmConfigurationAsync(array $args = [])
 * @method \MageBackup\Aws\Result createSnapshotCopyGrant(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createSnapshotCopyGrantAsync(array $args = [])
 * @method \MageBackup\Aws\Result createTags(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise createTagsAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteCluster(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteClusterAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteClusterParameterGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteClusterParameterGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteClusterSecurityGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteClusterSecurityGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteClusterSnapshot(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteClusterSnapshotAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteClusterSubnetGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteClusterSubnetGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteEventSubscription(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteEventSubscriptionAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteHsmClientCertificate(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteHsmClientCertificateAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteHsmConfiguration(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteHsmConfigurationAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteSnapshotCopyGrant(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteSnapshotCopyGrantAsync(array $args = [])
 * @method \MageBackup\Aws\Result deleteTags(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise deleteTagsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeClusterParameterGroups(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeClusterParameterGroupsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeClusterParameters(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeClusterParametersAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeClusterSecurityGroups(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeClusterSecurityGroupsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeClusterSnapshots(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeClusterSnapshotsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeClusterSubnetGroups(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeClusterSubnetGroupsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeClusterVersions(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeClusterVersionsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeClusters(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeClustersAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeDefaultClusterParameters(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeDefaultClusterParametersAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeEventCategories(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeEventCategoriesAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeEventSubscriptions(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeEventSubscriptionsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeEvents(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeEventsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeHsmClientCertificates(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeHsmClientCertificatesAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeHsmConfigurations(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeHsmConfigurationsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeLoggingStatus(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeLoggingStatusAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeOrderableClusterOptions(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeOrderableClusterOptionsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeReservedNodeOfferings(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeReservedNodeOfferingsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeReservedNodes(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeReservedNodesAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeResize(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeResizeAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeSnapshotCopyGrants(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeSnapshotCopyGrantsAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeTableRestoreStatus(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeTableRestoreStatusAsync(array $args = [])
 * @method \MageBackup\Aws\Result describeTags(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise describeTagsAsync(array $args = [])
 * @method \MageBackup\Aws\Result disableLogging(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise disableLoggingAsync(array $args = [])
 * @method \MageBackup\Aws\Result disableSnapshotCopy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise disableSnapshotCopyAsync(array $args = [])
 * @method \MageBackup\Aws\Result enableLogging(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise enableLoggingAsync(array $args = [])
 * @method \MageBackup\Aws\Result enableSnapshotCopy(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise enableSnapshotCopyAsync(array $args = [])
 * @method \MageBackup\Aws\Result modifyCluster(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise modifyClusterAsync(array $args = [])
 * @method \MageBackup\Aws\Result modifyClusterIamRoles(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise modifyClusterIamRolesAsync(array $args = [])
 * @method \MageBackup\Aws\Result modifyClusterParameterGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise modifyClusterParameterGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result modifyClusterSubnetGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise modifyClusterSubnetGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result modifyEventSubscription(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise modifyEventSubscriptionAsync(array $args = [])
 * @method \MageBackup\Aws\Result modifySnapshotCopyRetentionPeriod(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise modifySnapshotCopyRetentionPeriodAsync(array $args = [])
 * @method \MageBackup\Aws\Result purchaseReservedNodeOffering(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise purchaseReservedNodeOfferingAsync(array $args = [])
 * @method \MageBackup\Aws\Result rebootCluster(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise rebootClusterAsync(array $args = [])
 * @method \MageBackup\Aws\Result resetClusterParameterGroup(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise resetClusterParameterGroupAsync(array $args = [])
 * @method \MageBackup\Aws\Result restoreFromClusterSnapshot(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise restoreFromClusterSnapshotAsync(array $args = [])
 * @method \MageBackup\Aws\Result restoreTableFromClusterSnapshot(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise restoreTableFromClusterSnapshotAsync(array $args = [])
 * @method \MageBackup\Aws\Result revokeClusterSecurityGroupIngress(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise revokeClusterSecurityGroupIngressAsync(array $args = [])
 * @method \MageBackup\Aws\Result revokeSnapshotAccess(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise revokeSnapshotAccessAsync(array $args = [])
 * @method \MageBackup\Aws\Result rotateEncryptionKey(array $args = [])
 * @method \MageBackup\GuzzleHttp\Promise\Promise rotateEncryptionKeyAsync(array $args = [])
 */
class RedshiftClient extends AwsClient {}