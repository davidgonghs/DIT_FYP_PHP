/*
 Navicat Premium Data Transfer

 Source Server         : xampp
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : fyp

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 03/08/2021 18:26:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for t_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `t_admin_user`;
CREATE TABLE `t_admin_user`  (
  `user_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '管理员用户名',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '管理员用户名',
  UNIQUE INDEX `user_name`(`user_name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_admin_user
-- ----------------------------
INSERT INTO `t_admin_user` VALUES ('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- ----------------------------
-- Table structure for t_assessment
-- ----------------------------
DROP TABLE IF EXISTS `t_assessment`;
CREATE TABLE `t_assessment`  (
  `assessment_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `assessment_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subject_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` int NOT NULL COMMENT 'assignment=0,classwork=1,Tutorial=2, Midterm test=3,final exam=4,quize=5',
  `weight` int NOT NULL COMMENT 'percentage 百分比  40=40%',
  PRIMARY KEY (`assessment_id`) USING BTREE,
  INDEX `assessment_class_id`(`subject_id`) USING BTREE,
  CONSTRAINT `assessment_class_id` FOREIGN KEY (`subject_id`) REFERENCES `t_subject` (`subject_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_assessment
-- ----------------------------
INSERT INTO `t_assessment` VALUES ('6107de33ab746', 'CW1', '6107dcf3d745a', 1, 20);
INSERT INTO `t_assessment` VALUES ('6107de43ebf82', 'CW2', '6107dcf3d745a', 0, 40);
INSERT INTO `t_assessment` VALUES ('6107de5b85890', 'Final Exam', '6107dcf3d745a', 4, 40);

-- ----------------------------
-- Table structure for t_lo
-- ----------------------------
DROP TABLE IF EXISTS `t_lo`;
CREATE TABLE `t_lo`  (
  `lo_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `po_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lo_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lo_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subject_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  INDEX `lo_id`(`lo_id`) USING BTREE,
  INDEX `po_id`(`po_id`) USING BTREE,
  INDEX `subject_id`(`subject_id`) USING BTREE,
  CONSTRAINT `t_lo_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `t_po` (`po_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `t_lo_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `t_subject` (`subject_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_lo
-- ----------------------------
INSERT INTO `t_lo` VALUES ('6107dd17a90d7', '610768c2add90', 'LO1', 'Explain the concept of real-time system, features and purposes of hardware used in real-time systems', '6107dcf3d745a');
INSERT INTO `t_lo` VALUES ('6107dd2badff1', '610768d0f108f', 'LO2', 'Develop abilities of understanding and applying methods of analysis and design of real-time systems', '6107dcf3d745a');
INSERT INTO `t_lo` VALUES ('6107ddbf8a3eb', '610768db608c5', 'LO3', 'Develop skills in understanding and using basic scheduling algorithms', '6107dcf3d745a');
INSERT INTO `t_lo` VALUES ('6107ddd6dc648', '610768feadb99', 'LO4', 'Design simple real-time systems', '6107dcf3d745a');

-- ----------------------------
-- Table structure for t_po
-- ----------------------------
DROP TABLE IF EXISTS `t_po`;
CREATE TABLE `t_po`  (
  `po_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `po_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `po_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `program_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`po_id`) USING BTREE,
  INDEX `po_class_id`(`program_id`) USING BTREE,
  CONSTRAINT `t_po_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `t_program` (`program_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_po
-- ----------------------------
INSERT INTO `t_po` VALUES ('610768c2add90', 'PO1', 'Knowledge and Understanding', '60ffaab162ebd');
INSERT INTO `t_po` VALUES ('610768d0f108f', 'PO2', 'Cognitive Skills', '60ffaab162ebd');
INSERT INTO `t_po` VALUES ('610768db608c5', 'PO3', 'Practical Skills', '60ffaab162ebd');
INSERT INTO `t_po` VALUES ('610768ea55b5b', 'PO4', 'Interpersonal Skills', '60ffaab162ebd');
INSERT INTO `t_po` VALUES ('610768f4734b6', 'PO5', 'Communication Skills', '60ffaab162ebd');
INSERT INTO `t_po` VALUES ('610768feadb99', 'PO6', 'Digital Skills', '60ffaab162ebd');
INSERT INTO `t_po` VALUES ('6107690813f52', 'PO7', 'Numeracy Skills', '60ffaab162ebd');
INSERT INTO `t_po` VALUES ('61076911e1eff', 'PO8', 'Leadership, autonomy and responsibility', '60ffaab162ebd');
INSERT INTO `t_po` VALUES ('6107691c0d0eb', 'PO9', 'Personal Skills', '60ffaab162ebd');
INSERT INTO `t_po` VALUES ('61076925b5404', 'PO10', 'Entrepreneurship Skills', '60ffaab162ebd');
INSERT INTO `t_po` VALUES ('61076931dc8df', 'PO11', 'Ethics and Professionalism', '60ffaab162ebd');

-- ----------------------------
-- Table structure for t_program
-- ----------------------------
DROP TABLE IF EXISTS `t_program`;
CREATE TABLE `t_program`  (
  `program_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dean` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`program_id`) USING BTREE,
  INDEX `lecture`(`name`) USING BTREE,
  INDEX `dean`(`dean`) USING BTREE,
  CONSTRAINT `t_program_ibfk_1` FOREIGN KEY (`dean`) REFERENCES `t_teacher_user` (`staff_number`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_program
-- ----------------------------
INSERT INTO `t_program` VALUES ('60ffa857e6cdb', 'PUBLIC', 'FCUC00009');
INSERT INTO `t_program` VALUES ('60ffaab162ebd', 'Diploma in Information Technolog', 'FCUC00001');

-- ----------------------------
-- Table structure for t_question
-- ----------------------------
DROP TABLE IF EXISTS `t_question`;
CREATE TABLE `t_question`  (
  `question_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `assessment_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subject_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lo_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `question_code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `full_mark` decimal(3, 1) NOT NULL,
  PRIMARY KEY (`question_id`) USING BTREE,
  INDEX `qa_id`(`assessment_id`) USING BTREE,
  INDEX `qc_id`(`subject_id`) USING BTREE,
  INDEX `ql_id`(`lo_id`) USING BTREE,
  CONSTRAINT `qa_id` FOREIGN KEY (`assessment_id`) REFERENCES `t_assessment` (`assessment_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `qc_id` FOREIGN KEY (`subject_id`) REFERENCES `t_subject` (`subject_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ql_id` FOREIGN KEY (`lo_id`) REFERENCES `t_lo` (`lo_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_question
-- ----------------------------
INSERT INTO `t_question` VALUES ('6107de78a5a23', '6107de33ab746', '6107dcf3d745a', '6107dd17a90d7', '1a', 6.0);
INSERT INTO `t_question` VALUES ('6107de84b1649', '6107de33ab746', '6107dcf3d745a', '6107dd17a90d7', '1b', 10.0);
INSERT INTO `t_question` VALUES ('6107de8f7d26e', '6107de33ab746', '6107dcf3d745a', '6107dd17a90d7', '1c', 9.0);
INSERT INTO `t_question` VALUES ('6107de9553532', '6107de33ab746', '6107dcf3d745a', '6107dd17a90d7', '2a', 1.0);
INSERT INTO `t_question` VALUES ('6107de9c9b929', '6107de33ab746', '6107dcf3d745a', '6107dd17a90d7', '2b', 10.0);
INSERT INTO `t_question` VALUES ('6107deab48310', '6107de33ab746', '6107dcf3d745a', '6107dd17a90d7', '2c', 10.0);
INSERT INTO `t_question` VALUES ('6107deb0aafb3', '6107de33ab746', '6107dcf3d745a', '6107dd17a90d7', '2d', 4.0);
INSERT INTO `t_question` VALUES ('6107deb82d756', '6107de33ab746', '6107dcf3d745a', '6107dd17a90d7', '3a', 7.0);
INSERT INTO `t_question` VALUES ('6107dec43c1dd', '6107de33ab746', '6107dcf3d745a', '6107dd17a90d7', '3b', 10.0);
INSERT INTO `t_question` VALUES ('6107decd49c4c', '6107de33ab746', '6107dcf3d745a', '6107dd17a90d7', '3c', 6.0);
INSERT INTO `t_question` VALUES ('6107dee091f42', '6107de33ab746', '6107dcf3d745a', '6107dd2badff1', '4a', 10.0);
INSERT INTO `t_question` VALUES ('6107deeae4cf0', '6107de33ab746', '6107dcf3d745a', '6107dd2badff1', '4b', 10.0);
INSERT INTO `t_question` VALUES ('6107df7825f06', '6107de43ebf82', '6107dcf3d745a', '6107ddd6dc648', '1', 10.0);
INSERT INTO `t_question` VALUES ('6107df8022c31', '6107de43ebf82', '6107dcf3d745a', '6107ddd6dc648', '2', 10.0);
INSERT INTO `t_question` VALUES ('6107df8a3932c', '6107de43ebf82', '6107dcf3d745a', '6107ddd6dc648', '3', 5.0);
INSERT INTO `t_question` VALUES ('6107df925e18b', '6107de43ebf82', '6107dcf3d745a', '6107ddd6dc648', '4', 5.0);
INSERT INTO `t_question` VALUES ('6107e0220bef9', '6107de5b85890', '6107dcf3d745a', '6107dd17a90d7', '1a', 12.0);
INSERT INTO `t_question` VALUES ('6107e026c99ee', '6107de5b85890', '6107dcf3d745a', '6107dd17a90d7', '1b', 10.0);
INSERT INTO `t_question` VALUES ('6107e02c31a10', '6107de5b85890', '6107dcf3d745a', '6107dd17a90d7', '1c', 3.0);
INSERT INTO `t_question` VALUES ('6107e035a2ecb', '6107de5b85890', '6107dcf3d745a', '6107dd17a90d7', '2a', 1.0);
INSERT INTO `t_question` VALUES ('6107e03e9f519', '6107de5b85890', '6107dcf3d745a', '6107dd17a90d7', '2b', 10.0);
INSERT INTO `t_question` VALUES ('6107e0452cf2e', '6107de5b85890', '6107dcf3d745a', '6107dd17a90d7', '2c', 10.0);
INSERT INTO `t_question` VALUES ('6107e04c1df04', '6107de5b85890', '6107dcf3d745a', '6107dd17a90d7', '2d', 4.0);
INSERT INTO `t_question` VALUES ('6107e190b1db3', '6107de5b85890', '6107dcf3d745a', '6107dd2badff1', '3a', 1.5);
INSERT INTO `t_question` VALUES ('6107e19af01f7', '6107de5b85890', '6107dcf3d745a', '6107dd2badff1', '3b', 2.5);
INSERT INTO `t_question` VALUES ('6107e1a980bac', '6107de5b85890', '6107dcf3d745a', '6107dd2badff1', '3c', 1.0);
INSERT INTO `t_question` VALUES ('6107e1b30eddb', '6107de5b85890', '6107dcf3d745a', '6107dd2badff1', '3d', 15.0);
INSERT INTO `t_question` VALUES ('6107e1beba1f4', '6107de5b85890', '6107dcf3d745a', '6107dd2badff1', '3e', 5.0);
INSERT INTO `t_question` VALUES ('6107e1d985b55', '6107de5b85890', '6107dcf3d745a', '6107ddbf8a3eb', '4a', 20.0);
INSERT INTO `t_question` VALUES ('6107e1e8ae4bd', '6107de5b85890', '6107dcf3d745a', '6107ddbf8a3eb', '4b', 5.0);

-- ----------------------------
-- Table structure for t_question_marks
-- ----------------------------
DROP TABLE IF EXISTS `t_question_marks`;
CREATE TABLE `t_question_marks`  (
  `mark_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `question_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student_number` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mark` decimal(10, 1) NOT NULL,
  PRIMARY KEY (`mark_id`) USING BTREE,
  INDEX `mq_id`(`question_id`) USING BTREE,
  INDEX `ms_id`(`student_number`) USING BTREE,
  CONSTRAINT `mq_id` FOREIGN KEY (`question_id`) REFERENCES `t_question` (`question_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `ms_id` FOREIGN KEY (`student_number`) REFERENCES `t_student_user` (`student_number`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_question_marks
-- ----------------------------
INSERT INTO `t_question_marks` VALUES ('6107df14db662', '6107de78a5a23', 'B1146', 6.0);
INSERT INTO `t_question_marks` VALUES ('6107df14df563', '6107de84b1649', 'B1146', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107df14dff29', '6107de8f7d26e', 'B1146', 5.5);
INSERT INTO `t_question_marks` VALUES ('6107df14e139e', '6107de9553532', 'B1146', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107df14e1bb5', '6107de9c9b929', 'B1146', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df14e23d7', '6107deab48310', 'B1146', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df14e2dd7', '6107deb0aafb3', 'B1146', 2.0);
INSERT INTO `t_question_marks` VALUES ('6107df14e3775', '6107deb82d756', 'B1146', 2.0);
INSERT INTO `t_question_marks` VALUES ('6107df14e415f', '6107dec43c1dd', 'B1146', 2.0);
INSERT INTO `t_question_marks` VALUES ('6107df14e4a06', '6107decd49c4c', 'B1146', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107df14e53d4', '6107dee091f42', 'B1146', 13.0);
INSERT INTO `t_question_marks` VALUES ('6107df14e5cfc', '6107deeae4cf0', 'B1146', 6.5);
INSERT INTO `t_question_marks` VALUES ('6107df2b9872c', '6107de78a5a23', 'B1456', 6.0);
INSERT INTO `t_question_marks` VALUES ('6107df2b9c73e', '6107de84b1649', 'B1456', 10.0);
INSERT INTO `t_question_marks` VALUES ('6107df2b9cfe2', '6107de8f7d26e', 'B1456', 6.0);
INSERT INTO `t_question_marks` VALUES ('6107df2b9d798', '6107de9553532', 'B1456', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107df2b9ed8b', '6107de9c9b929', 'B1456', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df2b9f5be', '6107deab48310', 'B1456', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107df2b9fdec', '6107deb0aafb3', 'B1456', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df2ba06d4', '6107deb82d756', 'B1456', 3.0);
INSERT INTO `t_question_marks` VALUES ('6107df2ba0f07', '6107dec43c1dd', 'B1456', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df2ba175a', '6107decd49c4c', 'B1456', 6.0);
INSERT INTO `t_question_marks` VALUES ('6107df2ba1f1f', '6107dee091f42', 'B1456', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df2ba2714', '6107deeae4cf0', 'B1456', 2.0);
INSERT INTO `t_question_marks` VALUES ('6107df3cdd70d', '6107de78a5a23', 'B1499', 6.0);
INSERT INTO `t_question_marks` VALUES ('6107df3ce14ea', '6107de84b1649', 'B1499', 10.0);
INSERT INTO `t_question_marks` VALUES ('6107df3ce1d1e', '6107de8f7d26e', 'B1499', 9.0);
INSERT INTO `t_question_marks` VALUES ('6107df3ce2514', '6107de9553532', 'B1499', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107df3ce2d5c', '6107de9c9b929', 'B1499', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df3ce3aa8', '6107deab48310', 'B1499', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df3ce426c', '6107deb0aafb3', 'B1499', 3.0);
INSERT INTO `t_question_marks` VALUES ('6107df3ce4a61', '6107deb82d756', 'B1499', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df3ce51e5', '6107dec43c1dd', 'B1499', 10.0);
INSERT INTO `t_question_marks` VALUES ('6107df3ce5968', '6107decd49c4c', 'B1499', 6.0);
INSERT INTO `t_question_marks` VALUES ('6107df3ce6132', '6107dee091f42', 'B1499', 14.0);
INSERT INTO `t_question_marks` VALUES ('6107df3ce6958', '6107deeae4cf0', 'B1499', 9.0);
INSERT INTO `t_question_marks` VALUES ('6107df4ed35a5', '6107de78a5a23', 'B1515', 6.0);
INSERT INTO `t_question_marks` VALUES ('6107df4ed76a1', '6107de84b1649', 'B1515', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107df4ed80f3', '6107de8f7d26e', 'B1515', 5.5);
INSERT INTO `t_question_marks` VALUES ('6107df4ed8beb', '6107de9553532', 'B1515', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107df4ed9756', '6107de9c9b929', 'B1515', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df4eda107', '6107deab48310', 'B1515', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df4edabab', '6107deb0aafb3', 'B1515', 2.0);
INSERT INTO `t_question_marks` VALUES ('6107df4edb637', '6107deb82d756', 'B1515', 3.0);
INSERT INTO `t_question_marks` VALUES ('6107df4edc0d5', '6107dec43c1dd', 'B1515', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107df4edcaef', '6107decd49c4c', 'B1515', 1.5);
INSERT INTO `t_question_marks` VALUES ('6107df4edd568', '6107dee091f42', 'B1515', 11.0);
INSERT INTO `t_question_marks` VALUES ('6107df4eddfea', '6107deeae4cf0', 'B1515', 7.5);
INSERT INTO `t_question_marks` VALUES ('6107dfd3c2563', '6107df7825f06', 'B1146', 12.0);
INSERT INTO `t_question_marks` VALUES ('6107dfd3c63cd', '6107df8022c31', 'B1146', 15.0);
INSERT INTO `t_question_marks` VALUES ('6107dfd3c6ced', '6107df8a3932c', 'B1146', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107dfd3c7645', '6107df925e18b', 'B1146', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107dfdc22993', '6107df7825f06', 'B1456', 12.0);
INSERT INTO `t_question_marks` VALUES ('6107dfdc23449', '6107df8022c31', 'B1456', 15.0);
INSERT INTO `t_question_marks` VALUES ('6107dfdc23cd6', '6107df8a3932c', 'B1456', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107dfdc244ad', '6107df925e18b', 'B1456', 0.0);
INSERT INTO `t_question_marks` VALUES ('6107dff0f2146', '6107df7825f06', 'B1499', 12.0);
INSERT INTO `t_question_marks` VALUES ('6107dff101be4', '6107df8022c31', 'B1499', 20.0);
INSERT INTO `t_question_marks` VALUES ('6107dff102367', '6107df8a3932c', 'B1499', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107dff102a9e', '6107df925e18b', 'B1499', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107dffaba463', '6107df7825f06', 'B1515', 12.0);
INSERT INTO `t_question_marks` VALUES ('6107dffabe41a', '6107df8022c31', 'B1515', 15.0);
INSERT INTO `t_question_marks` VALUES ('6107dffabeca6', '6107df8a3932c', 'B1515', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107dffabf5db', '6107df925e18b', 'B1515', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2e456a', '6107e0220bef9', 'B1146', 10.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2e836c', '6107e026c99ee', 'B1146', 10.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2e8d59', '6107e02c31a10', 'B1146', 3.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2e96d7', '6107e035a2ecb', 'B1146', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2ea130', '6107e03e9f519', 'B1146', 10.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2ea94f', '6107e0452cf2e', 'B1146', 10.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2eb1c7', '6107e04c1df04', 'B1146', 3.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2ebaac', '6107e190b1db3', 'B1146', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2ec330', '6107e19af01f7', 'B1146', 2.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2ecbb6', '6107e1a980bac', 'B1146', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2ee1df', '6107e1b30eddb', 'B1146', 15.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2eea7d', '6107e1beba1f4', 'B1146', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107e2c2ef316', '6107e1d985b55', 'B1146', 16.5);
INSERT INTO `t_question_marks` VALUES ('6107e2c2efb0f', '6107e1e8ae4bd', 'B1146', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107e301ecd0d', '6107e0220bef9', 'B1456', 12.0);
INSERT INTO `t_question_marks` VALUES ('6107e301f0a33', '6107e026c99ee', 'B1456', 9.0);
INSERT INTO `t_question_marks` VALUES ('6107e301f11f0', '6107e02c31a10', 'B1456', 3.0);
INSERT INTO `t_question_marks` VALUES ('6107e301f197a', '6107e035a2ecb', 'B1456', 0.0);
INSERT INTO `t_question_marks` VALUES ('6107e301f2120', '6107e03e9f519', 'B1456', 0.0);
INSERT INTO `t_question_marks` VALUES ('6107e301f28e7', '6107e0452cf2e', 'B1456', 0.0);
INSERT INTO `t_question_marks` VALUES ('6107e301f3c98', '6107e04c1df04', 'B1456', 0.0);
INSERT INTO `t_question_marks` VALUES ('6107e302001de', '6107e190b1db3', 'B1456', 1.5);
INSERT INTO `t_question_marks` VALUES ('6107e302009f8', '6107e19af01f7', 'B1456', 1.5);
INSERT INTO `t_question_marks` VALUES ('6107e30201257', '6107e1a980bac', 'B1456', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107e30201ad3', '6107e1b30eddb', 'B1456', 7.0);
INSERT INTO `t_question_marks` VALUES ('6107e302023f4', '6107e1beba1f4', 'B1456', 0.0);
INSERT INTO `t_question_marks` VALUES ('6107e30202cf9', '6107e1d985b55', 'B1456', 7.5);
INSERT INTO `t_question_marks` VALUES ('6107e30203504', '6107e1e8ae4bd', 'B1456', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107e315e802e', '6107e0220bef9', 'B1499', 12.0);
INSERT INTO `t_question_marks` VALUES ('6107e315ec134', '6107e026c99ee', 'B1499', 10.0);
INSERT INTO `t_question_marks` VALUES ('6107e315ecbbc', '6107e02c31a10', 'B1499', 3.0);
INSERT INTO `t_question_marks` VALUES ('6107e315ee416', '6107e035a2ecb', 'B1499', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107e315eedd6', '6107e03e9f519', 'B1499', 8.0);
INSERT INTO `t_question_marks` VALUES ('6107e315ef6fe', '6107e0452cf2e', 'B1499', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107e315f0052', '6107e04c1df04', 'B1499', 0.5);
INSERT INTO `t_question_marks` VALUES ('6107e315f0981', '6107e190b1db3', 'B1499', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107e315f129b', '6107e19af01f7', 'B1499', 1.5);
INSERT INTO `t_question_marks` VALUES ('6107e315f1b04', '6107e1a980bac', 'B1499', 0.5);
INSERT INTO `t_question_marks` VALUES ('6107e315f23db', '6107e1b30eddb', 'B1499', 13.0);
INSERT INTO `t_question_marks` VALUES ('6107e315f2c19', '6107e1beba1f4', 'B1499', 0.0);
INSERT INTO `t_question_marks` VALUES ('6107e315f345a', '6107e1d985b55', 'B1499', 7.5);
INSERT INTO `t_question_marks` VALUES ('6107e315f3c5e', '6107e1e8ae4bd', 'B1499', 0.0);
INSERT INTO `t_question_marks` VALUES ('6107e32749ca8', '6107e0220bef9', 'B1515', 12.0);
INSERT INTO `t_question_marks` VALUES ('6107e3274a7e2', '6107e026c99ee', 'B1515', 9.0);
INSERT INTO `t_question_marks` VALUES ('6107e3274b0ca', '6107e02c31a10', 'B1515', 3.0);
INSERT INTO `t_question_marks` VALUES ('6107e3274b905', '6107e035a2ecb', 'B1515', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107e3274c192', '6107e03e9f519', 'B1515', 9.0);
INSERT INTO `t_question_marks` VALUES ('6107e3274c942', '6107e0452cf2e', 'B1515', 10.0);
INSERT INTO `t_question_marks` VALUES ('6107e3274d148', '6107e04c1df04', 'B1515', 4.0);
INSERT INTO `t_question_marks` VALUES ('6107e3274da16', '6107e190b1db3', 'B1515', 1.5);
INSERT INTO `t_question_marks` VALUES ('6107e3274e2f4', '6107e19af01f7', 'B1515', 2.5);
INSERT INTO `t_question_marks` VALUES ('6107e3274eba3', '6107e1a980bac', 'B1515', 1.0);
INSERT INTO `t_question_marks` VALUES ('6107e3274f3c3', '6107e1b30eddb', 'B1515', 12.0);
INSERT INTO `t_question_marks` VALUES ('6107e3274fbf4', '6107e1beba1f4', 'B1515', 5.0);
INSERT INTO `t_question_marks` VALUES ('6107e3275048a', '6107e1d985b55', 'B1515', 16.5);
INSERT INTO `t_question_marks` VALUES ('6107e32750c9b', '6107e1e8ae4bd', 'B1515', 0.0);

-- ----------------------------
-- Table structure for t_semester
-- ----------------------------
DROP TABLE IF EXISTS `t_semester`;
CREATE TABLE `t_semester`  (
  `semester_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `program_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `semester_infor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `semester_date` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`semester_id`) USING BTREE,
  INDEX `program_id`(`program_id`) USING BTREE,
  CONSTRAINT `t_semester_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `t_program` (`program_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_semester
-- ----------------------------
INSERT INTO `t_semester` VALUES ('610771e684671', '60ffaab162ebd', 'Year 2, Semester May', '2021-05');

-- ----------------------------
-- Table structure for t_semester_student
-- ----------------------------
DROP TABLE IF EXISTS `t_semester_student`;
CREATE TABLE `t_semester_student`  (
  `sms_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `semester_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student_number` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`sms_id`) USING BTREE,
  INDEX `student_number`(`student_number`) USING BTREE,
  INDEX `semester_id`(`semester_id`) USING BTREE,
  CONSTRAINT `t_semester_student_ibfk_2` FOREIGN KEY (`student_number`) REFERENCES `t_student_user` (`student_number`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `t_semester_student_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `t_semester` (`semester_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_semester_student
-- ----------------------------
INSERT INTO `t_semester_student` VALUES ('610771e684671B1146', '610771e684671', 'B1146');
INSERT INTO `t_semester_student` VALUES ('610771e684671B1456', '610771e684671', 'B1456');
INSERT INTO `t_semester_student` VALUES ('610771e684671B1499', '610771e684671', 'B1499');
INSERT INTO `t_semester_student` VALUES ('610771e684671B1515', '610771e684671', 'B1515');

-- ----------------------------
-- Table structure for t_student_user
-- ----------------------------
DROP TABLE IF EXISTS `t_student_user`;
CREATE TABLE `t_student_user`  (
  `student_number` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '默认为缩写的student number',
  `ic_passport` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `program_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '学院id',
  `status` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`student_number`) USING BTREE,
  INDEX `program_id`(`program_id`) USING BTREE,
  CONSTRAINT `t_student_user_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `t_program` (`program_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_student_user
-- ----------------------------
INSERT INTO `t_student_user` VALUES ('B1146', 'David Gong Hongshen', 'B1146@student.firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '60ffaab162ebd', 1);
INSERT INTO `t_student_user` VALUES ('B1456', 'Jeadon', 'B1456@student.firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '60ffaab162ebd', 1);
INSERT INTO `t_student_user` VALUES ('B1499', 'Jeremy Pun Kheng Ming', 'B1499@student.firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '60ffaab162ebd', 1);
INSERT INTO `t_student_user` VALUES ('B1515', 'Misa Pua Weixin', 'B1515@student.firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '60ffaab162ebd', 1);

-- ----------------------------
-- Table structure for t_subject
-- ----------------------------
DROP TABLE IF EXISTS `t_subject`;
CREATE TABLE `t_subject`  (
  `subject_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `program_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `model_sname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lecturer` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `semester_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`subject_id`) USING BTREE,
  INDEX `dean`(`lecturer`) USING BTREE,
  INDEX `program_id`(`program_id`) USING BTREE,
  INDEX `semester_id`(`semester_id`) USING BTREE,
  CONSTRAINT `dean` FOREIGN KEY (`lecturer`) REFERENCES `t_teacher_user` (`staff_number`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `t_subject_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `t_program` (`program_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `t_subject_ibfk_2` FOREIGN KEY (`semester_id`) REFERENCES `t_semester` (`semester_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_subject
-- ----------------------------
INSERT INTO `t_subject` VALUES ('6107723bd7181', '60ffaab162ebd', 'CDIT434', 'Internet Technology ', 'IT', 'FCUC00002', '610771e684671');
INSERT INTO `t_subject` VALUES ('6107724f436d0', '60ffaab162ebd', 'CDIT541', 'System Methodologies', 'SM', 'FCUC00003', '610771e684671');
INSERT INTO `t_subject` VALUES ('610772667aff2', '60ffaab162ebd', 'CDIT652', 'Human Computer Interaction', 'HCI', 'FCUC00004', '610771e684671');
INSERT INTO `t_subject` VALUES ('6107727c3e89b', '60ffaab162ebd', 'CDIT436', 'Fundamentals of Mobile Computi', 'FMC', 'FCUC00005', '610771e684671');
INSERT INTO `t_subject` VALUES ('610772959e863', '60ffaab162ebd', 'CDIT653', 'Cyber Marketing', 'CM', 'FCUC00006', '610771e684671');
INSERT INTO `t_subject` VALUES ('610772a82bab9', '60ffaab162ebd', 'CDIT651', 'Final Project', 'FYP', 'FCUC00007', '610771e684671');
INSERT INTO `t_subject` VALUES ('6107dcf3d745a', '60ffaab162ebd', 'CAPC3007', 'Real-time Analysis and Design', 'RAD', 'FCUC00001', '610771e684671');

-- ----------------------------
-- Table structure for t_teacher_user
-- ----------------------------
DROP TABLE IF EXISTS `t_teacher_user`;
CREATE TABLE `t_teacher_user`  (
  `staff_number` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '最开始用staff number 做密码',
  `program_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`staff_number`) USING BTREE,
  INDEX `program_id`(`program_id`) USING BTREE,
  CONSTRAINT `t_teacher_user_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `t_program` (`program_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of t_teacher_user
-- ----------------------------
INSERT INTO `t_teacher_user` VALUES ('FCUC00001', 'Lim Sin Chee', 'sc.lim@firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '60ffaab162ebd');
INSERT INTO `t_teacher_user` VALUES ('FCUC00002', 'Saniah', ' Saniah@firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '60ffaab162ebd');
INSERT INTO `t_teacher_user` VALUES ('FCUC00003', 'Siti Azirah', 'SitiAzirah@firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '60ffaab162ebd');
INSERT INTO `t_teacher_user` VALUES ('FCUC00004', 'SooLK', 'SooLK@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '60ffaab162ebd');
INSERT INTO `t_teacher_user` VALUES ('FCUC00005', 'KoongKL', 'KoongKL@firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '60ffaab162ebd');
INSERT INTO `t_teacher_user` VALUES ('FCUC00006', 'TanSY', 'TanSY@firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '60ffaab162ebd');
INSERT INTO `t_teacher_user` VALUES ('FCUC00007', 'Sherryn Lim', 'SherrynLim@firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '60ffaab162ebd');
INSERT INTO `t_teacher_user` VALUES ('FCUC00008', 'Siti Maria', 'SitiMaria@firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '60ffa857e6cdb');
INSERT INTO `t_teacher_user` VALUES ('FCUC00009', ' Siti Hajar', ' SitiHajar@firstcity.edu.my', '7c4a8d09ca3762af61e59520943dc26494f8941b', '60ffa857e6cdb');

SET FOREIGN_KEY_CHECKS = 1;
