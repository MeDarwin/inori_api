/*
 Navicat Premium Data Transfer

 Source Server         : base
 Source Server Type    : MySQL
 Source Server Version : 100428 (10.4.28-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : inori

 Target Server Type    : MySQL
 Target Server Version : 100428 (10.4.28-MariaDB)
 File Encoding         : 65001

 Date: 17/12/2023 23:14:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category
-- ----------------------------

-- ----------------------------
-- Table structure for division
-- ----------------------------
DROP TABLE IF EXISTS `division`;
CREATE TABLE `division`  (
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `division_lead` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vision` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mission` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `division_division_lead_index`(`division_lead` ASC) USING BTREE,
  CONSTRAINT `division_division_lead_foreign` FOREIGN KEY (`division_lead`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of division
-- ----------------------------
INSERT INTO `division` VALUES ('magazine', 'div.lead.inori', 'Making a good magazine for the club and entertain everyone with amazing content.', '1. To promote the club activities and members.\\n2. To promote the club activities and members.\\n3. To promote the club activities and members.', '2023-12-17 23:14:34', '2023-12-17 23:14:34');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for favourite
-- ----------------------------
DROP TABLE IF EXISTS `favourite`;
CREATE TABLE `favourite`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `magazine_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `favourite_username_index`(`username` ASC) USING BTREE,
  INDEX `favourite_magazine_id_index`(`magazine_id` ASC) USING BTREE,
  CONSTRAINT `favourite_magazine_id_foreign` FOREIGN KEY (`magazine_id`) REFERENCES `magazine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `favourite_username_foreign` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of favourite
-- ----------------------------

-- ----------------------------
-- Table structure for magazine
-- ----------------------------
DROP TABLE IF EXISTS `magazine`;
CREATE TABLE `magazine`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `creator_username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `verified_by` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `thumbnail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `footer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `post_schedule` timestamp NOT NULL DEFAULT current_timestamp,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `magazine_creator_username_index`(`creator_username` ASC) USING BTREE,
  INDEX `magazine_verified_by_index`(`verified_by` ASC) USING BTREE,
  CONSTRAINT `magazine_creator_username_foreign` FOREIGN KEY (`creator_username`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `magazine_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of magazine
-- ----------------------------

-- ----------------------------
-- Table structure for magazine_category
-- ----------------------------
DROP TABLE IF EXISTS `magazine_category`;
CREATE TABLE `magazine_category`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `magazine_id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `magazine_category_magazine_id_index`(`magazine_id` ASC) USING BTREE,
  INDEX `magazine_category_category_name_index`(`category_name` ASC) USING BTREE,
  CONSTRAINT `magazine_category_category_name_foreign` FOREIGN KEY (`category_name`) REFERENCES `category` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `magazine_category_magazine_id_foreign` FOREIGN KEY (`magazine_id`) REFERENCES `magazine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of magazine_category
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (3, '2023_12_11_120209_create_categories_table', 1);
INSERT INTO `migrations` VALUES (4, '2023_12_11_120646_create_visitor_counts_table', 1);
INSERT INTO `migrations` VALUES (5, '2023_12_11_131142_create_magazines_table', 1);
INSERT INTO `migrations` VALUES (6, '2023_12_11_135111_create_divisions_table', 1);
INSERT INTO `migrations` VALUES (7, '2023_12_11_140136_create_user_divisions_table', 1);
INSERT INTO `migrations` VALUES (8, '2023_12_11_141112_create_favourites_table', 1);
INSERT INTO `migrations` VALUES (9, '2023_12_11_141257_create_magazine_categories_table', 1);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis_nip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nisn` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('member','admin','club_leader','osis','club_mentor') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`username`) USING BTREE,
  UNIQUE INDEX `user_email_unique`(`email` ASC) USING BTREE,
  UNIQUE INDEX `user_nis_nip_unique`(`nis_nip` ASC) USING BTREE,
  UNIQUE INDEX `user_nisn_unique`(`nisn` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('admin.inori', '123456789012', '2122121212', 'admin@example.com', '$2y$12$DE1WFN1ZEV2PT9F6eA1C9eJs.wv8ZmD.e.P9yNJPnn.pcUbGPeTIe', 'admin', '2023-12-17 23:14:30', '2023-12-17 23:14:30');
INSERT INTO `user` VALUES ('div.lead.inori', '123456789017', '2122121217', 'div.lead@example.com', '$2y$12$HKI0NSnpWD91AWa7qQmyGOE5X7mqzELPOXdDcq8eD9LMlL1xYe1oG', 'member', '2023-12-17 23:14:34', '2023-12-17 23:14:34');
INSERT INTO `user` VALUES ('div.magazine.inori', '123456789018', '2122121218', 'div.magazine@example.com', '$2y$12$TdxcyCGenR5mRYo1Hh80c.qPKvEfC2egmOPs50x1Fd1C2nf8U1NeG', 'member', '2023-12-17 23:14:34', '2023-12-17 23:14:34');
INSERT INTO `user` VALUES ('leader.inori', '123456789014', '2122121214', 'leader@example.com', '$2y$12$DUjUIiD6E9l5hpTrcYnt1OjTl3aA0Io396kHJo1LLLAMIrNH22Qu.', 'club_leader', '2023-12-17 23:14:32', '2023-12-17 23:14:32');
INSERT INTO `user` VALUES ('member.inori', '123456789013', '2122121213', 'member@example.com', '$2y$12$YAO5uwzsbPEcfGYJo1WdAOKvdQett8OxwdAeX4dGj70SSv8wWqJCi', 'member', '2023-12-17 23:14:31', '2023-12-17 23:14:31');
INSERT INTO `user` VALUES ('mentor.inori', '123456789015', '2122121215', 'mentor@example.com', '$2y$12$K7SaukDCdcqsiwwRdJYB6OyJv/DTBUaStKRPAD8YFS5Z.xmZZC9B.', 'club_mentor', '2023-12-17 23:14:32', '2023-12-17 23:14:32');
INSERT INTO `user` VALUES ('osis.inori', '123456789016', '2122121216', 'osis@example.com', '$2y$12$KRpufupt1dHhVIo4Z6xOdO/wiBkuRzXuBg5MU9f1u/EW.Zzs4MgkK', 'osis', '2023-12-17 23:14:33', '2023-12-17 23:14:33');

-- ----------------------------
-- Table structure for user_division
-- ----------------------------
DROP TABLE IF EXISTS `user_division`;
CREATE TABLE `user_division`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `division_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_division_user_username_index`(`user_username` ASC) USING BTREE,
  INDEX `user_division_division_name_index`(`division_name` ASC) USING BTREE,
  CONSTRAINT `user_division_division_name_foreign` FOREIGN KEY (`division_name`) REFERENCES `division` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_division_user_username_foreign` FOREIGN KEY (`user_username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_division
-- ----------------------------
INSERT INTO `user_division` VALUES (1, 'div.magazine.inori', 'magazine');

-- ----------------------------
-- Table structure for visitor_count
-- ----------------------------
DROP TABLE IF EXISTS `visitor_count`;
CREATE TABLE `visitor_count`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp,
  `view_url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `visitor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of visitor_count
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
