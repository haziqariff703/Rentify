-- ============================================
-- RENTIFY DATABASE MIGRATION
-- Add Booking Add-ons & Pickup Location
-- ============================================
-- 
-- Instructions:
-- 1. Open phpMyAdmin
-- 2. Select your 'rentify' database
-- 3. Click on "SQL" tab
-- 4. Paste this entire file and click "Go"
--
-- ============================================

-- Add new columns to bookings table
ALTER TABLE bookings 
ADD COLUMN pickup_location VARCHAR(100) NULL AFTER total_price,
ADD COLUMN addons JSON NULL AFTER pickup_location,
ADD COLUMN addons_total DECIMAL(10,2) DEFAULT 0.00 AFTER addons;

-- ============================================
-- COLUMN DESCRIPTIONS:
-- ============================================
--
-- | Column          | Type          | Purpose                                    |
-- |-----------------|---------------|-------------------------------------------|
-- | pickup_location | VARCHAR(100)  | "airport", "city", "north", "south"       |
-- | addons          | JSON          | ["chauffeur", "insurance", "gps"]         |
-- | addons_total    | DECIMAL(10,2) | Calculated add-ons price (e.g., 280.00)   |
--
-- ============================================
-- EXAMPLE DATA AFTER BOOKING:
-- ============================================
--
-- pickup_location: "airport"
-- addons: ["chauffeur", "insurance"]
-- addons_total: 280.00
--
-- (For 4 days: Chauffeur RM50×4 + Insurance RM20×4 = RM280)
--
-- ============================================
-- ADD-ON PRICES (Per Day):
-- ============================================
--
-- Chauffeur Service:      RM 50/day
-- Full Coverage Insurance: RM 20/day
-- GPS Navigation:         RM 10/day
--
-- ============================================
