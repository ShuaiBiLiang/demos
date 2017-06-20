<?php

/**
 * 项目中的单例工厂类
 */
class Factory {
	/**
	 * 生成模型的单例对象
	 * @param string $model_name
	 * @return object
	 */
	public static function M($model_name) {
		static $model_list = array();
		// 键=>值
		// 模型名=>模型对象
		if(!isset($model_list[$model_name])) {
			// 说明没有被实例化过
			$model_list[$model_name] = new $model_name;
		}
		return $model_list[$model_name];
	}
}