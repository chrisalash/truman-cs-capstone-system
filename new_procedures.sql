CREATE PROCEDURE `Get_Student_Time_Table` ()
BEGIN
SELECT IF(spring2023.id=null,1,0) slot_taken,time_start, time_end FROM spring2023;
END
