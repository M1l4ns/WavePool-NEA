import os
import wave, struct, math, random
from pydub import AudioSegment
from pydub.effects import normalize
from pydub.playback import play
import matplotlib.pyplot as plt
import scipy.io.wavfile
import librosa
import librosa.display
import IPython.display as ipd
from math import log10, floor
from os import path
  
def roundToSig(x, sig=3):
   return round(x, sig-int(floor(log10(abs(x))))-1)

#Preparing all files
userDrop = "SoundFile.mp3"
tempWav = "SoundFile.wav"
compareWav = "SoundFile2.wav"
compareWav2 = "SoundFile3.wav"
noMatch = "noMatch.wav"
  
songToCheck = AudioSegment.from_mp3(userDrop)
songToCheck.export(tempWav, format="wav")


tempWavSegment = AudioSegment.from_wav(tempWav)
def getSongData(x): #Getting the song data
    songDataTable = []

    sampleWidth = x.sample_width
    songDataTable.append(sampleWidth)

    sampleChannels = x.channels
    songDataTable.append(sampleChannels)
    
    sampleFrameRate = x.frame_rate
    songDataTable.append(sampleFrameRate)

    sampleMaxAmp = x.max
    songDataTable.append(sampleMaxAmp)

    sampleDuration = (len(x)*0.001)/60
    songDataTable.append(sampleDuration)

    return songDataTable

songData = getSongData(tempWavSegment)
print(songData)
tempWavSegment2 = AudioSegment.from_wav(compareWav)
songData2 = getSongData(tempWavSegment2)
tempWavSegment3 = AudioSegment.from_wav(compareWav2)
songData3 = getSongData(tempWavSegment3)
tempWavSegment4 = AudioSegment.from_wav(noMatch)
songData4 = getSongData(tempWavSegment4)

#Searching for matches using other data
finalList = []
for data in songData:
    if data in songData4:
        finalList.append(data)
    else:
        finalList.append("nul")
if "nul" not in finalList:
    print("Match Found!")
else:
    print("No Match Found...")
    print("Checking Pitch...")
    transposeAmount = -10
    for x in range(0,1500):
        signiDigits = 4
        newPitch = int((songData[2])*(2.0**transposeAmount))
        newPitchRound = roundToSig(newPitch)
        if (newPitchRound == int(songData4[2]) or newPitchRound-1 == int(songData4[2])) and songData4[3]==songData[3] and songData4[0]==songData[0]:
            print("Match Found In Pitch Change!!!")
            found = True
            break
        else:
            #print(songData3[2],newPitchRound)
            found = False
            transposeAmount = transposeAmount + 0.01
    if found == False:
        print(songData[0])
        print(songData4[0])
        print("No Match Found ;)")


#Getting the waves:
wavRate, wavData = scipy.io.wavfile.read("noMatch.wav")
#plt.plot(wavData)
#plt.show()

#Comparing
soundFileForIntervals = wave.open("noMatch.wav",'wb')
soundFileForIntervals.getnframes()