<?php
/**
 * TestLink Open Source Project - http://testlink.sourceforge.net/ 
 * This script is distributed under the GNU General Public License 2 or later. 
 *
 * Filename $RCSfile: attachmentdelete.php,v $
 *
 * @version $Revision: 1.8 $
 * @modified $Date: 2008/11/21 21:00:41 $ by $Author: schlundus $
 *
 * Deletes an attachment by a given id
 */
require_once('../../config.inc.php');
require_once('../functions/common.php');
require_once('../functions/attachments.inc.php');
testlinkInitPage($db);

//the id (attachments.id) of the attachment to be deleted 
$bDeleted = false;
$id = isset($_GET['id'])? intval($_GET['id']) : 0;
if ($id)
{
	$attachmentRepository = tlAttachmentRepository::create($db);
	$attachmentInfo = $attachmentRepository->getAttachmentInfo($id);
	if ($attachmentInfo && checkAttachmentID($db,$id,$attachmentInfo))
	{
		$bDeleted = $attachmentRepository->deleteAttachment($id,$attachmentInfo);
		if ($bDeleted)
			logAuditEvent(TLS("audit_attachment_deleted",$attachmentInfo['title']),"DELETE",$id,"attachments");
	}
}

$smarty = new TLSmarty();
$smarty->assign('bDeleted',$bDeleted);
$smarty->display('attachmentdelete.tpl');
?>
