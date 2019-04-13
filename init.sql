CREATE TABLE "torrent" (
  "hashString" text NOT NULL,
  "addedDate" numeric NOT NULL,
  "id" integer NOT NULL,
  "name" text NOT NULL,
  PRIMARY KEY ("hashString")
);

ALTER TABLE "torrent" ADD "transfertDate" numeric NULL;
