<?php
class UserTask {
	
	public static function delete($userId, $taskId){
		$sql = "DELETE FROM user_tasks WHERE user_id = :user_id AND task_id = :task_id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':user_id', $userId);
		$stmt->bindParam(':task_id', $taskId);
		return $stmt->execute();
	}
	
	public static function create($userId, $taskId){
		$sql = "SELECT 1 FROM user_tasks WHERE user_id = :user_id AND task_id = :task_id";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':user_id', $userId);
		$stmt->bindParam(':task_id', $taskId);
		$stmt->execute();
		if($stmt->fetchColumn()===1){
			return false;
		}
		
		$sql = "INSERT INTO user_tasks VALUES(:user_id, :task_id)";
		$stmt = getDB()->prepare($sql);
		$stmt->bindParam(':user_id', $userId);
		$stmt->bindParam(':task_id', $taskId);
		return $stmt->execute();
	}
	
}