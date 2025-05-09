library(readxl)
library(readr)
library(dplyr)
library(stringr)
library(tidyr)
library(splitstackshape)

movies = read.csv("movies.csv")
tags = read.csv("tags.csv")
links = read.csv("links.csv")
ratings = read.csv("ratings.csv")

title.basics = read_tsv("title.basics.tsv")
title.basics = title.basics[c(1, 3, 4, 6, 7, 8)]

title.crew = read_tsv("title.crew.tsv")
names.basics = read_tsv("names.basics.tsv")


title.basics = title.basics %>%
  mutate(tconst = gsub('t', '', tconst)) %>%
  mutate(tconst = str_remove(tconst, "^0+"))
         
         
title.basics = title.basics %>%
  rename(imdbId = tconst)

links = links[1:2]
links = links %>%
  mutate(imdbId = as.character(imdbId))
         
# user(userID, name, password) 

user_tb = data.frame(x, name = "Anonymous", password = "ABC123")
user_tb = user_tb %>%
  rename(userID = x)

# movie(movieID, title, release_year, synopsis, imdbID) 
         
merged = left_join(links, title.basics)
merged2 = left_join(movies, merged) %>%
  drop_na(primaryTitle) %>%
  rename(releaseYear = startYear, title2 = primaryTitle) %>%
  mutate(imdbId = as.integer(imdbId))

movie_tb = merged2[c(1, 5, 7, 4)] %>%
  rename(title = title2)

# imdb_info(imdbID, runtime, avgRating, numRatings)

ratings2 = ratings %>%
  group_by(movieId) %>%
  summarise(avg_rating = round(mean(rating), 2), numRatings = n())

merged3 = left_join(merged2, ratings2)

imdb_tb = merged3[c(4, 9, 10, 11)] %>%
  rename(runtime = runtimeMinutes) %>%
  mutate(numRatings = ifelse(is.na(numRatings), 0, numRatings))

# movie_genre(movieID, gname)

genres = merged3[c(1, 3)]
genre_tb = cSplit(genres, "genres", "|", "long")

# review(userID, movieID, rating, content) 

rating_tb = ratings[c(1, 2, 3)] %>%
  mutate(content = "")

rating_tb = rating_tb %>%
  rename(userID = userId, movieID = movieId)

# review_tag(userID, movieID, tag_desc) 

tag_tb = tags[c(1, 2, 3)] %>%
  rename(tagDesc = tag)

tag_tb = tag_tb %>%
  rename(userID = userId, movieID = movieId)

# crew(crewID, cname)

crew_tb = names.basics[c(1, 2)]

crew_tb = crew_tb %>%
  rename(crewID = nconst, cname = primaryName)

# crew_job(crewID, jobTitle) 

all_jobs = cSplit(names.basics, "primaryProfession", ",", "long")

job_tb = all_jobs[, c(1, 5)] %>%
  rename(jobTitle = primaryProfession) %>%
  mutate(jobTitle = gsub('_', ' ', jobTitle)) %>%
  mutate(jobTitle = str_to_title(jobTitle))  

job_tb = job_tb %>%
  drop_na(jobTitle)

job_tb = job_tb %>%
  rename(crewID = nconst)

# works_for(crewID, movieID)

movie_crew = cSplit(names.basics[c(6, 1)], "knownForTitles", ",", "long")

movie_crew = movie_crew %>%
  filter(knownForTitles != '\\N')
  
movie_crew = movie_crew %>%
  rename(imdbId = knownForTitles) %>%
  mutate(imdbId = gsub('t', '', imdbId)) %>%
  mutate(imdbId = str_remove(imdbId, "^0+"))

movie_crew = movie_crew %>%
  mutate(imdbId = as.integer(imdbId))

merged6 = left_join(incl_movies, movie_crew)

incl = merged6[c(4, 1, 2)] %>%
  rename(crewID = nconst)

works_tb = merged6[c(4, 1)] %>%
  rename(crewID = nconst)



works_tb = works_tb %>%
  rename(movieID = movieId)

## MORE CLEANING...  crew_job(crewID, jobTitle) 

test = left_join(incl, job_tb)
job_tb = test[c(1, 4)]

test = left_join(incl,crew_tb)
crew_tb = test[c(1, 4)]

## EXPORT

movie_tb = movie_tb %>%
  mutate(releaseYear = as.integer(releaseYear))

write.csv(user_tb, "export_data\\users.csv", row.names=FALSE)
write.csv(movie_tb, "export_data\\movie.csv", row.names=FALSE)
write.csv(imdb_tb, "imdb.csv", row.names=FALSE)
write.csv(genre_tb, "export_data\\genre.csv", row.names=FALSE)
write.csv(rating_tb, "export_data\\rating.csv", row.names=FALSE)
write.csv(tag_tb, "export_data\\tag.csv", row.names=FALSE)
write.csv(crew, "crew.csv", row.names=FALSE)
write.csv(jobs, "job.csv", row.names=FALSE)
write.csv(works_tb, "export_data\\works.csv", row.names=FALSE)



