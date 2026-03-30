import { z } from 'zod';

// Define the base object schema separately to allow .pick() and .omit()
export const hotelBaseSchema = z.object({
  // Basic Information
  name: z.string().min(3, "Hotel name must be at least 3 characters").max(100, "Hotel name too long"),

  description: z.string().min(10, "Description must be at least 10 characters").max(1000, "Description too long"),

  email: z.email("Invalid email address"),

  phone: z.string().min(10, "Phone number is required"),

  hobby: z.string().min(2, "hobby is required"),
  sport: z.string().min(2, "sport is required"),

  website: z.url("Enter a valid website URL").optional().or(z.literal("")),

  // Location
  country: z.string().min(2, "Country is required"),
  city: z.string().min(2, "City is required"),
  address: z.string().min(5, "Address is required"),

  postalCode: z
    .string()
    .regex(/^[A-Za-z0-9\s-]{3,10}$/, "Enter a valid postal code")
    .optional(),

  // Hotel Details
  starRating: z.coerce
    .number({
      invalid_type_error: "Star rating must be a number",
    })
    .min(1, "Minimum 1 star")
    .max(5, "Maximum 5 stars"),

  totalRooms: z.coerce
    .number({
      invalid_type_error: "Total rooms must be a number",
    })
    .min(1, "Must have at least 1 room"),

  checkInTime: z
    .string()
    .regex(/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/, "Enter valid time in HH:MM format"),

  checkOutTime: z
    .string()
    .regex(/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/, "Enter valid time in HH:MM format"),

  // Amenities
  amenities: z
    .array(z.string())
    .min(1, "Select at least one amenity"),

  // Policies
  cancellationPolicy: z
    .string()
    .min(10, "Policy must be at least 10 characters")
    .max(500),

  // Account Info
  username: z
    .string()
    .min(4, "Username must be at least 4 characters"),

  password: z
    .string()
    .min(8, "Password must be at least 8 characters")
    .regex(/[A-Z]/, "Must contain at least one uppercase letter")
    .regex(/[0-9]/, "Must contain at least one number"),

  confirmPassword: z
    .string()
    .min(8, "Confirm password required"),
});

// The final schema used for overall registration (with refinements)
export const hotelRegistrationSchema = hotelBaseSchema.refine((data) => data.password === data.confirmPassword, {
  message: "Passwords don't match",
  path: ["confirmPassword"],
});
